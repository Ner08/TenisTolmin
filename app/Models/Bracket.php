<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bracket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'league_id',
        'description',
        'tag',
        'points_description',
        'is_group_stage',
        'places_from',
        'places_to',
        'green_rows',
        'orange_up_rows',
        'orange_down_rows',
        'red_rows',
    ];

    /**
     * Determine the promotion/relegation zone for a standings position.
     *
     * @param  int  $position  1-based rank (1 = top of the standings).
     * @param  int  $total     Total number of ranked rows.
     * @return array{color:string,label:string}|null  Zone color + label, or null.
     */
    public function zoneInfo(int $position, int $total): ?array
    {
        $green      = (int) $this->green_rows;
        $orangeUp   = (int) $this->orange_up_rows;
        $orangeDown = (int) $this->orange_down_rows;
        $red        = (int) $this->red_rows;

        // Layout, top to bottom:
        //   green       – advance directly
        //   orange up   – qualification match to advance (just below green)
        //   (uncoloured middle)
        //   orange down – qualification match to stay    (just above red)
        //   red         – out
        if ($green > 0 && $position <= $green) {
            return ['color' => 'green', 'label' => 'Napreduje'];
        }
        if ($red > 0 && $position > $total - $red) {
            return ['color' => 'red', 'label' => 'Izpade'];
        }
        if ($orangeUp > 0 && $position > $green && $position <= $green + $orangeUp) {
            return ['color' => 'orange', 'label' => 'Kval. naprej'];
        }
        if ($orangeDown > 0 && $position > $total - $red - $orangeDown && $position <= $total - $red) {
            return ['color' => 'orange', 'label' => 'Kval. obstanek'];
        }
        return null;
    }

    /**
     * Get the teams in the bracket.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the teams in the bracket.
     */
    public function matchUps(): HasMany
    {
        return $this->hasMany(CustomMatchUp::class);
    }

    /**
     * Get the user that owns the Bracket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function bracketComments(): HasMany
    {
        return $this->hasMany(BracketComment::class);
    }
}


