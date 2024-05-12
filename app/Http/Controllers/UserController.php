<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Request;

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

            return redirect('/')->with(['message' => 'Prijava uspešna!']);
        }

        return back()->withErrors(['email' => 'Uporabniško ime, e-mail ali geslo ni pravilno.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        // Clear the remember me token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Odjava uspešna!');
    }
}
