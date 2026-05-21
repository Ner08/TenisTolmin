<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;
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

    protected $attributes = [
        'points' => 0,
    ];

    public function scopeFilter($query, array $filter) {
        if ($filter['search_players'] ?? false) {
            $query->where('p_name', 'like', '%' . request('search_players') . '%');
        }
    }

    public function ranking() {
        $rank = $this->newQuery()
            ->where(function ($query) {
                $query->where('points', '>', $this->points)
                      ->orWhere(function ($query) {
                          $query->where('points', $this->points)
                                ->where('p_name', '<', $this->p_name);
                      });
            })
            ->count();

        return $rank + 1;
    }
}
