<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationApprovedMail;
use App\Mail\RegistrationNotifyAdminMail;
use App\Mail\RegistrationRejectedMail;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function showForm()
    {
        $players = Player::where('is_fake', false)
            ->doesntHave('user')
            ->orderBy('p_name')
            ->get();

        return view('register.index', ['players' => $players]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'unique:users,email'],
            'password'             => ['required', 'confirmed', 'min:8'],
            'player_choice'        => ['required', 'in:existing,new,none'],
            'player_id'            => ['nullable', 'exists:players,id', 'unique:users,player_id'],
            'registration_comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $playerId = null;

        if ($validated['player_choice'] === 'existing') {
            $playerId = $validated['player_id'] ?? null;
        } elseif ($validated['player_choice'] === 'new') {
            $player = Player::create([
                'p_name'  => $validated['name'],
                'is_fake' => false,
                'points'  => 0,
            ]);
            $playerId = $player->id;
        }

        $user = User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'password'             => $validated['password'],
            'is_admin'             => false,
            'player_id'            => $playerId,
            'registration_status'  => 'pending',
            'registration_comment' => $validated['registration_comment'] ?? null,
        ]);

        $adminUser = User::where('is_admin', true)->first();
        if ($adminUser) {
            Mail::to($adminUser->email)->send(new RegistrationNotifyAdminMail($user));
        }

        return redirect()->route('login_view')
            ->with('message', 'Registracija oddana. Čakajte na odobritev administratorja.');
    }

    public function approve(User $user)
    {
        $user->update(['registration_status' => 'approved']);
        Mail::to($user->email)->send(new RegistrationApprovedMail($user));
        return back()->with('message', 'Registracija odobrena.');
    }

    public function reject(User $user)
    {
        $user->update(['registration_status' => 'rejected']);
        Mail::to($user->email)->send(new RegistrationRejectedMail($user));
        return back()->with('message', 'Registracija zavrnjena.');
    }

    public function makeAdmin(User $user)
    {
        abort_unless(auth()->user()->is_super_admin, 403);
        abort_if($user->is_super_admin, 403, 'Ne morete spremeniti super admina.');
        $user->update(['is_admin' => true]);
        return back()->with('message', $user->name . ' je zdaj admin.');
    }

    public function removeAdmin(User $user)
    {
        abort_unless(auth()->user()->is_super_admin, 403);
        abort_if($user->is_super_admin, 403, 'Ne morete spremeniti super admina.');
        abort_if($user->id === auth()->id(), 403, 'Ne morete odstraniti lastnih admin pravic.');
        $user->update(['is_admin' => false]);
        return back()->with('message', 'Admin pravice odstranjene.');
    }

    public function adminCreate(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'min:8'],
            'player_id' => ['nullable', 'exists:players,id', 'unique:users,player_id'],
        ]);

        User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'password'            => $validated['password'],
            'is_admin'            => false,
            'player_id'           => $validated['player_id'] ?? null,
            'registration_status' => 'approved',
        ]);

        return back()->with('message', 'Uporabnik ustvarjen.');
    }

    public function linkPlayer(Request $request, User $user)
    {
        $request->validate([
            'player_id' => ['nullable', 'exists:players,id', 'unique:users,player_id,NULL,id,id,' . $user->id],
        ]);

        $user->update(['player_id' => $request->player_id ?: null]);

        return back()->with('message', 'Igralec povezan z uporabnikom ' . $user->name . '.');
    }

    public function setTempPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', Password::min(8)],
        ]);

        $user->update(['password' => $request->password]);

        return back()->with('message', 'Začasno geslo za ' . $user->name . ' je bilo nastavljeno.');
    }
}
