<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\CustomMatchUp;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\League;
use App\Models\Membership;
use App\Models\News;
use App\Models\Player;
use App\Models\Team;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'leagues' => League::latest()->paginate(6),
            'events' => Event::latest()->filter(request(['search_events']))->paginate(6),
            'news' => News::latest()->filter(request(['search_news']))->paginate(6),
            'players' => Player::orderBy('p_name')->filter(request(['search_players']))->paginate(21),
            'gallery' => Gallery::orderBy('home_page', 'desc') // Items with home_page first
                ->orderBy('created_at', 'desc') // Then order by creation date
                ->filter(request(['search_gallery']))
                ->paginate(12),
            'membership' => Membership::first(),
            'search_players' => request('search_players'),
            'search_news' => request('search_news'),
            'search_events' => request('search_events'),
            'search_leagues' => request('search_leagues'),
            'search_gallery' => request('search_gallery'),
        ]);
    }

    public function bracket_setup(League $league)
    {
        $brackets = Bracket::where('league_id', $league->id)->latest()->paginate(12);
        return view('admin.bracket_store', [
            'league' => $league,
            'brackets' => $brackets,
            'playersSelect' =>  Player::where('id', '!=', 1)->orderBy('p_name')->get(),
            'players' => Player::orderBy('is_fake')->orderBy('p_name')->get(),
        ]);
    }
    public function matchup_setup(Bracket $bracket)
    {
        return view('admin.matchup_store', [
            'bracket' => $bracket,
            'matchups' => CustomMatchUp::where('bracket_id', $bracket->id)->orderBy('round')->paginate(21),
            'teams' => Team::where('bracket_id', $bracket->id)->get(),
            'numOfTeams' => Team::where('bracket_id', $bracket->id)->where('is_fake', false)->count(),
            'playersSelect' => Player::where('id', '!=', 1)->orderBy('p_name')->get(),
            'players' => Player::orderBy('is_fake')->orderBy('p_name')->get(),
        ]);
    }

    public function matchup_edit(Bracket $bracket, $customMatchUp)
    {
        $matchUp = CustomMatchUp::findOrFail($customMatchUp);
        return view('admin.matchup_edit', [
            'bracket' => $bracket,
            'matchup' => $matchUp,
            'teams' => Team::where('bracket_id', $bracket->id)->get(),
        ]);
    }

    public function player_edit(Player $player)
    {
        return view('admin.player_edit', [
            'player' => $player,
        ]);
    }

    public function news_edit(News $news)
    {
        return view('admin.news_edit', [
            'news' => $news,
        ]);
    }

    public function event_edit(Event $event)
    {
        return view('admin.event_edit', [
            'event' => $event,
        ]);
    }
}
