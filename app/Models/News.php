<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    public function scopeFilter($query, array $filter) {
        if ($filter['search_news'] ?? false) {
            $query->where('title', 'like', '%' . request('search_news') . '%')
            ->orWhere('content', 'like', '%' . request('search_news') . '%');
        }
    }
}
