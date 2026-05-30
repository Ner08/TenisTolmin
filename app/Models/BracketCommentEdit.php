<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BracketCommentEdit extends Model
{
    protected $fillable = ['bracket_comment_id', 'user_id', 'previous_content'];

    public function comment() { return $this->belongsTo(BracketComment::class, 'bracket_comment_id'); }
    public function user()    { return $this->belongsTo(User::class); }
}
