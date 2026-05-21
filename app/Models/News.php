<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::forceDeleting(function (News $news) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
        });
    }

    protected $fillable = [
        'title',
        'content',
        'image',
    ];

    public function scopeFilter($query, array $filter) {
        if ($filter['search_news'] ?? false) {
            $query->where('title', 'like', '%' . request('search_news') . '%')
            ->orWhere('content', 'like', '%' . request('search_news') . '%');
        }
    }
}
