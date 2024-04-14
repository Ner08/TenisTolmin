<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function numOfPlayers(): int {
        return $this->p2_name ? 2 : 1;
    }
}
