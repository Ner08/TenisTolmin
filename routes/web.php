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
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::post('/news', [NewsController::class, 'store'])->name('news_store')->middleware('admin_api');
Route::put('/news{news}', [NewsController::class, 'edit'])->name('news_edit')->middleware('admin_api');
Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news_destroy')->middleware('admin_api');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news_detail');

// Leagues
Route::get('/leagues', [LeaguesController::class, 'index'])->name('leagues');
Route::get('/leagues/{league}', [LeaguesController::class, 'show'])->name('league');
Route::post('/leagues', [LeaguesController::class, 'store'])->name('leagues.store')->middleware('admin_api');
Route::put('/leagues/{league}', [LeaguesController::class, 'edit'])->name('leagues.edit')->middleware('admin_api');
Route::delete('/leagues/{league}', [LeaguesController::class, 'destroy'])->name('league.destroy')->middleware('admin_api');

// Brackets
Route::post('/leagues/brackets', [LeaguesController::class, 'bracket_store'])->name('leagues.bracket_store')->middleware('admin_api');
Route::put('/leagues/brackets/{bracket}', [LeaguesController::class, 'bracket_edit'])->name('leagues.bracket_edit')->middleware('admin_api');
Route::delete('/leagues/brackets/{bracket}', [LeaguesController::class, 'bracket_destroy'])->name('league.bracket_destroy')->middleware('admin_api');

//Matchups
Route::post('/leagues/matchups', [LeaguesController::class, 'matchup_store'])->name('leagues.matchup_store')->middleware('admin_api');
Route::put('/leagues/matchups/{customMatchup}', [LeaguesController::class, 'matchup_edit'])->name('leagues.matchup_edit')->middleware('admin_api');
Route::delete('/leagues/matchups/{matchup}', [LeaguesController::class, 'matchup_destroy'])->name('league.matchup_destroy')->middleware('admin_api');

// Scoreboard
Route::get('/scoreboard', [LeaguesController::class, 'showScoreBoard'])->name('scoreboard');

// Login/Logout
Route::get('/admin', [LoginController::class, 'index'])->name('login_view');
;

//Admin
Route::get('/admin_board', [AdminController::class, 'index'])->name('admin')->middleware('admin_view');
Route::get('/admin/league/bracket/{league}', [AdminController::class, 'bracket_setup'])->name('bracket_setup')->middleware('admin_view');
Route::get('/admin/league/matchup/{bracket}', [AdminController::class, 'matchup_setup'])->name('matchup_setup')->middleware('admin_view');
Route::get('/admin/league/matchup/{bracket}/{customMatchup}', [AdminController::class, 'matchup_edit'])->name('matchup_edit')->middleware('admin_view');
Route::get('/admin/player/{player}', [AdminController::class, 'player_edit'])->name('player_edit')->middleware('admin_view');
Route::get('/admin/news/{news}', [AdminController::class, 'news_edit'])->name('news_edit_view')->middleware('admin_view');
Route::get('/admin/event/{event}', [AdminController::class, 'event_edit'])->name('event_edit')->middleware('admin_view');

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Membership
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::post('/events', [EventController::class, 'store'])->name('events_store')->middleware('admin_api');
Route::put('/events/{event}', [EventController::class, 'edit'])->name('events_edit')->middleware('admin_api');
Route::delete('/events{event}', [EventController::class, 'destroy'])->name('events_destroy')->middleware('admin_api');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events_detail');

//Players
Route::post('/players', [PlayerController::class, 'store'])->name('players_store')->middleware('admin_api');
Route::put('/players/{player}', [PlayerController::class, 'edit'])->name('players_edit')->middleware('admin_api');
Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players_destroy')->middleware('admin_api');
Route::post('/players/{player_id}/points_add', [PlayerController::class, 'add_points'])->name('players_add_points')->middleware('admin_api');

//Users
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('authenticate');
Route::post('/users/logout', [UserController::class, 'logout'])->name('logout')->middleware('user_api');

//Exceptions
Route::fallback(function () {
    // Handle 404 errors here
    return response()->view('errors.error-404', [], 404);
});

Route::get('/error/403', function () {
    // Handle 403 errors here
    return view('errors.error-403');
})->name('error403');
