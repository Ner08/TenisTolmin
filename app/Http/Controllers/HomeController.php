<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\League;
use App\Models\Gallery;

class HomeController extends Controller
{
    // Get the Home view
    public function index()
    {
        return view('home.index', [
            'news' => News::latest()->paginate(3),
            'events' => Event::latest()->paginate(6),
            'leagues' => League::latest()->where('l_home_page', true)->paginate(3),
            'gallery' => Gallery::latest()->where('home_page', true)->paginate(3),
        ]);
    }
}
