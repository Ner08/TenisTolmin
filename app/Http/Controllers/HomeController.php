<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\League;

class HomeController extends Controller
{
    // Get the Home view
    public function index()
    {
        return view('home.index', [
            'news' => News::latest()->paginate(6),
            'events' => Event::latest()->paginate(6),
            'leagues' => League::latest()->paginate(3),
            'login' => false,
            'admin' => true
        ]);
    }
}
