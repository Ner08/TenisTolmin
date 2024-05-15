<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'g_title',
        'g_image',
    ];
    public function scopeFilter($query, array $filter) {
        if ($filter['search_gallery'] ?? false) {
            $query->where('g_title', 'like', '%' . request('search_gallery') . '%');
        }
    }
}
