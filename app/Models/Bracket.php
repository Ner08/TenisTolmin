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
        'orange_rows',
        'red_rows',
    ];

    /**
     * Determine the promotion/relegation zone color for a standings position.
     *
     * @param  int  $position  1-based rank (1 = top of the standings).
     * @param  int  $total     Total number of ranked rows.
     * @return string|null     'green' | 'orange' | 'red', or null for no tint.
     */
    public function zoneColor(int $position, int $total): ?string
    {
        $green  = (int) $this->green_rows;
        $orange = (int) $this->orange_rows;
        $red    = (int) $this->red_rows;

        // Green sits at the top, red at the bottom, and orange directly above
        // the red band (green → uncolored middle → orange → red).
        if ($green > 0 && $position <= $green) {
            return 'green';
        }
        if ($red > 0 && $position > $total - $red) {
            return 'red';
        }
        if ($orange > 0 && $position > $total - $red - $orange && $position <= $total - $red) {
            return 'orange';
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


