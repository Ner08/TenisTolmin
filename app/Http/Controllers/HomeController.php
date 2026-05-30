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
            'news' => News::latest()->paginate(4),
            'events' => Event::latest()->paginate(4),
            'leagues' => League::latest()->where('l_home_page', true)->paginate(4),
            'gallery' => Gallery::latest()->where('home_page', true)->paginate(4),
        ]);
    }
}
