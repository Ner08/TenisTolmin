<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\BracketComment;
use App\Models\BracketCommentEdit;
use App\Models\Event;
use App\Models\EventComment;
use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeNews(Request $request, News $news)
    {
        $request->validate(['content' => ['required', 'string', 'max:1000']]);

        NewsComment::create([
            'news_id' => $news->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('message', 'Komentar objavljen.');
    }

    public function destroyNews(NewsComment $comment)
    {
        abort_unless(auth()->id() === $comment->user_id || auth()->user()->is_admin, 403);
        $comment->delete();
        return back()->with('message', 'Komentar zbrisan.');
    }

    public function storeEvent(Request $request, Event $event)
    {
        $request->validate(['content' => ['required', 'string', 'max:1000']]);

        EventComment::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('message', 'Komentar objavljen.');
    }

    public function destroyEvent(EventComment $comment)
    {
        abort_unless(auth()->id() === $comment->user_id || auth()->user()->is_admin, 403);
        $comment->delete();
        return back()->with('message', 'Komentar zbrisan.');
    }

    public function pollBracket(Request $request, Bracket $bracket)
    {
        $after    = $request->integer('after', 0);
        $comments = $bracket->bracketComments()
            ->with('user')
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get()
            ->map(fn($c) => [
                'id'         => $c->id,
                'content'    => $c->content,
                'user_id'    => $c->user_id,
                'user_name'  => $c->user->name,
                'created_at' => $c->created_at->format('d.m. H:i'),
                'ts'         => $c->created_at->timestamp,
                'delete_url' => route('brackets.chat.destroy', $c->id),
                'update_url' => $c->user_id === auth()->id() ? route('brackets.chat.update', $c->id) : null,
                'is_own'     => $c->user_id === auth()->id(),
                'is_edited'  => (bool) $c->is_edited,
                'initials'   => collect(explode(' ', $c->user->name ?? '?'))
                                    ->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode(''),
            ]);

        return response()->json($comments);
    }

    public function storeBracket(Request $request, Bracket $bracket)
    {
        $request->validate(['content' => ['required', 'string', 'max:500']]);

        $comment = BracketComment::create([
            'bracket_id' => $bracket->id,
            'user_id'    => auth()->id(),
            'content'    => $request->content,
        ]);

        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'id'         => $comment->id,
                'content'    => $comment->content,
                'user_id'    => $comment->user_id,
                'user_name'  => $comment->user->name,
                'created_at' => $comment->created_at->format('d.m. H:i'),
                'ts'         => $comment->created_at->timestamp,
                'delete_url' => route('brackets.chat.destroy', $comment->id),
                'update_url' => route('brackets.chat.update', $comment->id),
            ]);
        }

        return back()->with('message', 'Sporočilo poslano.');
    }

    public function destroyBracket(BracketComment $comment)
    {
        abort_unless(auth()->id() === $comment->user_id || auth()->user()->is_admin, 403);
        $comment->delete();
        if (request()->expectsJson()) return response()->json(['ok' => true]);
        return back()->with('message', 'Sporočilo zbrisano.');
    }

    public function updateBracket(Request $request, BracketComment $comment)
    {
        abort_unless(auth()->id() === $comment->user_id, 403);
        $request->validate(['content' => ['required', 'string', 'max:500']]);

        BracketCommentEdit::create([
            'bracket_comment_id' => $comment->id,
            'user_id'            => auth()->id(),
            'previous_content'   => $comment->content,
        ]);

        $comment->update(['content' => $request->content, 'is_edited' => true]);

        return response()->json(['content' => $comment->content, 'is_edited' => true]);
    }
}
