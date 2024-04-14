<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaguesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news_detail');

// Leagues
Route::get('/leagues', [LeaguesController::class, 'index'])->name('leagues');
Route::get('/leagues/{league}', [LeaguesController::class, 'show'])->name('league');
Route::post('/leagues', [LeaguesController::class,'store'])->name('leagues.store');
Route::post('/leagues/brackets', [LeaguesController::class,'bracket_store'])->name('leagues.bracket_store');

Route::get('/scoreboard', [LeaguesController::class, 'showScoreBoard'])->name('scoreboard');

// Login/Logout
Route::get('/login_view', [LoginController::class, 'index'])->name('login_view');;

//Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/leagues', [AdminController::class, 'leagues_index'])->name('league_managment');
Route::get('/admin/league/bracket/{league}', [AdminController::class, 'bracket_setup'])->name('bracket_setup');
Route::get('/admin/league/matchup/{bracket}', [AdminController::class, 'mathcup_setup'])->name('matchup_setup');

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Membership
Route::get('/membership',[MembershipController::class, 'index'])->name('membership');

// Events
Route::get('/events',[EventController::class, 'index'])->name('events');
Route::get('/events/{event}',[EventController::class, 'show'])->name('events_detail');
