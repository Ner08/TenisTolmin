<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'short_description', 'start_date', 'end_date'];

    /**
     * Get the brackets in the league.
     */
    public function brackets(): HasMany
    {
        return $this->hasMany(Bracket::class);
    }

}
