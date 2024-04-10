<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\League;
use App\Models\News;
use App\Models\Player;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'events' => Event::orderBy('fromDate')->get(),
            'news' => News::orderBy('created_at')->get(),
            'leagues' => League::orderBy('start_date')->get(),
            'players' => Player::orderBy('created_at')->get(),
            'login' => true
        ]);
    }
}
