<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::forceDeleting(function (Gallery $gallery) {
            if ($gallery->g_image) {
                Storage::disk('public')->delete($gallery->g_image);
            }
        });
    }

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
        'home_page',
    ];
    public function scopeFilter($query, array $filter) {
        if ($filter['search_gallery'] ?? false) {
            $query->where('g_title', 'like', '%' . request('search_gallery') . '%');
        }
    }
}
