<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'message', 'url', 'read_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public static function notify(int $userId, string $type, string $title, string $message, ?string $url = null): void
    {
        static::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'url'     => $url,
        ]);
    }
}
