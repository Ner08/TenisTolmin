<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location',
        'fromDate',
        'toDate',
        'e_title',
        'e_description'
    ];
    public function scopeFilter($query, array $filter) {
        if ($filter['search_events'] ?? false) {
            $query->where('title', 'like', '%' . request('search_events') . '%')
            ->orWhere('description', 'like', '%' . request('search_events') . '%');
        }
    }
}
