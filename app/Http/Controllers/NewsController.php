<?php

namespace App\Http\Controllers;

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
            'login' => false
        ]);
    }

    //Show single news
    public function show(News $news)
    {
        $comments = NewsComment::where('news_id', 1)->paginate(10);
        return view('news.show', [
            'newsItem' => $news, 'login' => false,
            'comments' => $comments
        ]);
    }
}
