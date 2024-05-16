<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'l_home_page'];

    /**
     * Get the brackets in the league.
     */
    public function brackets(): HasMany
    {
        return $this->hasMany(Bracket::class);
    }
    public function scopeFilter($query, array $filter) {
        if ($filter['search_leagues'] ?? false) {
            $query->where('name', 'like', '%' . request('search_leagues') . '%')
            ->orWhere('description', 'like', '%' . request('search_leagues') . '%');
        }
    }
}
