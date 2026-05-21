<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

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
            $query->where('e_title', 'like', '%' . request('search_events') . '%')
            ->orWhere('e_description', 'like', '%' . request('search_events') . '%');
        }
    }
}
