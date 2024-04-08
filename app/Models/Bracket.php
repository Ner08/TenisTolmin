<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bracket extends Model
{
    use HasFactory;

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


