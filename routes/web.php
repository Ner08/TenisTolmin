<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaguesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlayerController;
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
Route::delete('/leagues/{league}', [LeaguesController::class, 'destroy'])->name('league.destroy');
Route::delete('/leagues/brackets/{bracket}', [LeaguesController::class, 'bracket_destroy'])->name('league.bracket_destroy');
Route::delete('/leagues/matchup/{matchup}', [LeaguesController::class, 'matchup_destroy'])->name('league.matchup_destroy');
Route::post('/leagues/brackets', [LeaguesController::class,'bracket_store'])->name('leagues.bracket_store');
Route::post('/leagues/matchups', [LeaguesController::class, 'matchup_store'])->name('leagues.matchup_store');


Route::get('/scoreboard', [LeaguesController::class, 'showScoreBoard'])->name('scoreboard');

// Login/Logout
Route::get('/login_view', [LoginController::class, 'index'])->name('login_view');;

//Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/league/bracket/{league}', [AdminController::class, 'bracket_setup'])->name('bracket_setup');
Route::get('/admin/league/matchup/{bracket}', [AdminController::class, 'matchup_setup'])->name('matchup_setup');

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Membership
Route::get('/membership',[MembershipController::class, 'index'])->name('membership');

// Events
Route::get('/events',[EventController::class, 'index'])->name('events');
Route::get('/events/{event}',[EventController::class, 'show'])->name('events_detail');
Route::post('/events',[EventController::class, 'store'])->name('events_store');


//Players
Route::post('/players', [PlayerController::class, 'store'])->name('players_store');
Route::post('/players/{player_id}/points_add', [PlayerController::class, 'add_points'])->name('players_add_points');
