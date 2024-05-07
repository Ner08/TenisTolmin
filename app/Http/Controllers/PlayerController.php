<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    public function store(PlayerRequest $request)
    {
        // Create player
        Player::create($request->validated());

        return back()->with(['message' => 'Igralec uspešno ustvarjen(a)']);
    }

    public function add_points(Request $request, $player_id)
    {
        // Find the player by ID
        $player = Player::findOrFail($player_id);

        // Retrieve points from the request
        $points = $request->input('points');

        // Add points to the player
        $player->points += $points;
        $player->save();

        return back()->with(['message' => 'Točke uspešno dodane.'], 200);
    }
}
