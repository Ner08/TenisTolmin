<?php

namespace App\Http\Controllers;

use App\Models\News;

class HomeController extends Controller
{
    // Get the Home view
    public function index()
    {
        return view('home.index', [
            'newsItems' => News::paginate(6),
            'login' => false
        ]);
    }
}
