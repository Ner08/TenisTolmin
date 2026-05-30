<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function authenticate(AuthenticationRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $usernameOrEmail = $request->input('email');
        $remember = $request->has('remember');

        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            // Input is an email address, attempt authentication using email field
            $credentials['email'] = $usernameOrEmail;
        } else {
            // Input is not an email address, attempt authentication using name field
            $credentials['name'] = $usernameOrEmail;
            unset($credentials['email']);
        }

        /* dd($credentials); */
        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $status = auth()->user()->registration_status;
            if ($status === 'pending') {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Vaša registracija še čaka na odobritev administratorja.'])->onlyInput('email');
            }
            if ($status === 'rejected') {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Vaša registracija je bila zavrnjena.'])->onlyInput('email');
            }

            return redirect('/')->with(['message' => 'Prijava uspešna!']);
        }

        return back()->withErrors(['email' => 'Uporabniško ime, e-mail ali geslo ni pravilno.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Odjava uspešna!');
    }

    public function settings()
    {
        return view('settings.index');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('profile_success', 'Podatki so bili posodobljeni.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Trenutno geslo ni pravilno.'])->withFragment('password');
        }

        auth()->user()->update(['password' => $request->password]);

        return back()->with('password_success', 'Geslo je bilo uspešno spremenjeno.')->withFragment('password');
    }
}
