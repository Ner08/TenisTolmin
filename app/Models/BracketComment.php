<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BracketComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['bracket_id', 'user_id', 'content', 'is_edited'];

    public function edits() { return $this->hasMany(BracketCommentEdit::class, 'bracket_comment_id')->latest(); }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bracket(): BelongsTo
    {
        return $this->belongsTo(Bracket::class);
    }
}
