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
    $searchMode = request(['search_players','search_news', 'search_events']);
    $scroll = key($searchMode) == 'search_players' ? '#players' : (key($searchMode) == 'search_news' ? '#news' : (key($searchMode) == 'search_events' ? '#events' : NULL));

    return view('admin.index', [
        'events' => Event::orderBy('fromDate')->filter(request(['search_events']))->paginate(12),
        'news' => News::latest()->filter(request(['search_news']))->paginate(12),
        'leagues' => League::orderBy('start_date')->get(),
        'players' => Player::orderBy('name')->filter(request(['search_players']))->paginate(21),
        'search_players' => request('search_players'),
        'search_news' => request('search_news'),
        'search_events' => request('search_events'),
        'login' => true,
        'admin' => false, // So the admin icon does not show up
        'scroll' => $scroll
    ]);
}
}
