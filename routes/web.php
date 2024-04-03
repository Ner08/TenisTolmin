<?php

use App\Models\News;
use App\Models\NewsComment;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.home', ['newsItems' => News::paginate(12), 'login' => false]);
});

Route::get('/news', function(){
    return view('layouts.news', ['newsItems' => News::paginate(12), 'login' => false]);
})->name('news');
;

Route::get('/news/{news}', function(News $news){

return view('layouts.news_detail', ['newsItem' => $news, 'login' => false, 'comments' => NewsComment::where('news_id', 1)->paginate(10)]);
})->where('id','[0-9]+')->name('news_detail');;

Route::get('/leagues', function(){
    return view('layouts.news', ['login' => false]);
});

Route::get('/leagues/{id}', function($id){
    return view('layouts.news', ['id' => $id, 'login' => false]);
})->where('id','[0-9]+');

Route::get('login_view', function(){
    return view('layouts.login');
})->name('login_view');;

Route::get('admin', function(){
    return view('layouts.admin', ['login' => false]);
})->name('admin');

Route::get('contact', function(){
    return view('layouts.contact', ['login' => false]);
})->name('contact');
