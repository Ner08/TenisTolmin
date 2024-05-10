<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'p_name', // Corrected the column name to 'p_name'
        'points',
        'is_fake'
    ];

    public function scopeFilter($query, array $filter) {
        if ($filter['search_players'] ?? false) {
            $query->where('p_name', 'like', '%' . request('search_players') . '%');
        }
    }

    public function ranking() {
        // Get the count of players who have more points than the current player
        $rank = $this->newQuery()
            ->where('points', '>', $this->points)
            ->count();

        // Add 1 to the rank to account for 0-based indexing
        return $rank + 1;
    }
}
