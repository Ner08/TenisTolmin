<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Get the Login view
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('home')->with('message', 'Ste že prijavljeni v račun. Če se želite prijaviti v drug račun se najprej odjavite.');
        }
        return view('login.index');
    }
}
