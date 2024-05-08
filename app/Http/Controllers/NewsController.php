<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //Show all news
    public function index()
    {
        $newsItems = News::paginate(12);
        return view('news.index', [
            'newsItems' => $newsItems,
            'login' => false,
            'admin' => true
        ]);
    }

    //Show single news
    public function show(News $news)
    {
        $comments = NewsComment::where('news_id', 1)->paginate(10);
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
        /* dd($request->file('image')); */
        $formFields = $request->validated();

        if ($request->hasFile('image')) {
            /* dd('here'); */
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        /* dd($formFields); */
        News::create($formFields);

        return back()->with(['message' => 'Novica uspešno ustvarjen(a)']);
    }

}
