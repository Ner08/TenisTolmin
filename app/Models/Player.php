<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filter) {
        if ($filter['search_players'] ?? false) {
            $query->where('name', 'like', '%' . request('search_players') . '%');
        }
    }
}
