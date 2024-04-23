<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bracket_id',
        'p1_id',
        'p2_id',
    ];

    /**
     * Get the user that owns the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bracket(): BelongsTo
    {
        return $this->belongsTo(Bracket::class);
    }

    /**
     * The roles that belong to the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matchups(): HasMany
    {
        return $this->hasMany(CustomMatchUp::class, 'team1_id')->orWhere('team2_id', $this->id);
    }

    /**
     * Get the user associated with the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function player1(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'p1_id');
    }

    /**
     * Get the user associated with the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function player2(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'p2_id');
    }
    /**
     * Get the players associated with the Team.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'id', 'p1_id')
            ->orWhere('id', $this->p2_id);
    }

    public function numOfPlayers(): int
    {
        return $this->p2_name ? 2 : 1;
    }

    /**
     * Calculate the total points of the team in the bracket
     *
     * @return int
     */
    public function group_points(): int
    {
        $points = 0;

        // Iterate over each matchup
        foreach ($this->matchups as $matchup) {
            // Check if the team won
            if ($this->id === $matchup->team1_id) {
                if ($matchup->t1SetsWon() === 2 && $matchup->t2SetsWon() === 0) {
                    // Team won 2:0
                    $points += 3;
                } elseif ($matchup->t1SetsWon() === 1 && $matchup->t2SetsWon() === 2) {
                    // Team lost 1:2
                    $points += 1;
                }
            } elseif ($this->id === $matchup->team2_id) {
                if ($matchup->t2SetsWon() === 2 && $matchup->t1SetsWon() === 0) {
                    // Team won 2:0
                    $points += 3;
                } elseif ($matchup->t2SetsWon() === 1 && $matchup->t1SetsWon() === 2) {
                    // Team lost 1:2
                    $points += 1;
                }
            }
        }
        return $points;
    }
    public function group_set_delta(): int
    {
        $delta = 0;

        // Iterate over each matchup
        foreach ($this->matchups as $matchup) {
            // Check if the team won
            if ($this->id === $matchup->team1_id) {
                $delta += $matchup->t1SetsWon() - $matchup->t2SetsWon();
            } elseif ($this->id === $matchup->team2_id) {
                $delta += $matchup->t2SetsWon() - $matchup->t1SetsWon();
            }
        }
        return $delta;
    }
    public function group_game_delta(): int
    {
        $delta = 0;

        // Iterate over each matchup
        foreach ($this->matchups as $matchup) {
            // Check if the team won
            if ($this->id === $matchup->team1_id) {
                $delta += $matchup->t1_first_set - $matchup->t2_first_set;
                $delta += $matchup->t1_second_set - $matchup->t2_second_set;
                $delta += $matchup->t1_third_set - $matchup->t2_third_set;
            } elseif ($this->id === $matchup->team2_id) {
                $delta += $matchup->t2_first_set - $matchup->t1_first_set;
                $delta += $matchup->t2_second_set - $matchup->t1_second_set;
                $delta += $matchup->t2_third_set - $matchup->t1_third_set;
            }
        }
        return $delta;
    }
}
