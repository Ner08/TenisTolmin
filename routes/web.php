<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaguesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NewsController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news_detail');

// Leagues
Route::get('/leagues', function(){
    return view('layouts.news', ['login' => false]);
})->name('leagues');

Route::get('/leagues/{id}', function($id){
    return view('layouts.news', ['id' => $id, 'login' => false]);
})->name('leagues_detail');

Route::get('/scoreboard', [LeaguesController::class, 'showScoreBoard'])->name('scoreboard');

// Login/Logout
Route::get('/login_view', [LoginController::class, 'index'])->name('login_view');;

//Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Membership
Route::get('/membership',[MembershipController::class, 'index'])->name('membership');
