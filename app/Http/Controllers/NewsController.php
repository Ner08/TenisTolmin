<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    //Show all news
    public function index()
    {
        return view('news.index', [
            'newsItems' => News::latest()->paginate(12),
            'login' => false,
            'admin' => true
        ]);
    }

    //Show single news
    public function show(News $news)
    {
        $comments = NewsComment::where('news_id', $news->id)->latest()->paginate(10);
        return view('news.show', [
            'newsItem' => $news,
            'login' => false,
            'comments' => $comments,
            'admin' => true
        ]);
    }

    //Store news
    public function store(NewsRequest $request)
    {
        $formFields = $request->validated();

        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        News::create($formFields);

        return back()->with(['message' => 'Novica uspešno posodobljiva']);
    }

    //Edit news
    public function edit(News $news, NewsRequest $request)
    {
        $formFields = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            Storage::disk('public')->delete($news->image);
            // Store the new image
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        $news->update($formFields);

        return redirect()->route('admin')->with(['message' => 'Novica uspešno posodobljena']);
    }

    public function destroy(News $news)
    {
        // Delete the image from the server
        Storage::disk('public')->delete($news->image);
        // Delete the news item from the database
        $news->delete();

        return back()->with(['message' => 'Novica uspešno zbirsana(a)']);
    }

}
