<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;

class HomeController extends Controller
{
    // Get the Home view
    public function index()
    {
        return view('home.index', [
            'news' => News::paginate(6),
            'events' => Event::paginate(6),
            'login' => false
        ]);
    }
}
