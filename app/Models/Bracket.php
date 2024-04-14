<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bracket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'league_id',
        'description',
        'is_group_stage',
    ];

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
}


