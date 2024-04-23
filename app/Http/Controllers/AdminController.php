<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\CustomMatchUp;
use App\Models\Event;
use App\Models\League;
use App\Models\News;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $searchMode = request(['search_players', 'search_news', 'search_events']);
        $scroll = key($searchMode) == 'search_players' ? '#players' : (key($searchMode) == 'search_news' ? '#news' : (key($searchMode) == 'search_events' ? '#events' : NULL));

        return view('admin.index', [
            'leagues' => League::latest()->paginate(21),
            'events' => Event::latest()->filter(request(['search_events']))->paginate(12),
            'news' => News::latest()->filter(request(['search_news']))->paginate(12),
            'players' => Player::orderBy('p_name')->filter(request(['search_players']))->paginate(21),
            'search_players' => request('search_players'),
            'search_news' => request('search_news'),
            'search_events' => request('search_events'),
            'search_leagues' => request('search_leagues'),
            'login' => true,
            'admin' => false, // So the admin icon does not show up
            'scroll' => $scroll
        ]);
    }

    public function leagues_index()
    {
        return view('admin.leagues.index', [
            'leagues' => League::orderBy('start_date')->paginate(12),
            'players' => Player::orderBy('is_fake')->orderBy('p_name')->get(),
            'login' => true,
            'admin' => false, // So the admin icon does not show up
        ]);
    }

    public function bracket_setup(League $league)
    {
        $brackets = Bracket::where('league_id', $league->id)->latest()->paginate(12);
        return view('admin.bracket_store', [
            'league' => $league,
            'brackets' => $brackets,
            'players' => Player::orderBy('is_fake')->orderBy('p_name')->get(),
            'login' => true,
            'admin' => false, // So the admin icon does not show up
        ]);
    }
    public function matchup_setup(Bracket $bracket)
    {
        return view('admin.matchup_store', [
            'bracket' => $bracket,
            'matchups' => CustomMatchUp::orderBy('round')->paginate(21),
            'teams' => Team::where('bracket_id', $bracket->id)->get(),
            'players' => Player::orderBy('is_fake')->orderBy('p_name')->get(),
            'login' => true,
            'admin' => false, // So the admin icon does not show up
        ]);
    }
}
