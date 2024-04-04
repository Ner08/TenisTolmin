<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Get the Login view
    public function index()
    {
        return view('login.index');
    }
}
