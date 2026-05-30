<?php

use App\Mail\MembershipMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LeaguesController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MatchResultController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegistrationController;

//Storage
Route::get('/storage/{filename}', [StorageController::class, 'show'])->name('storage.show');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::post('/news', [NewsController::class, 'store'])->name('news_store')->middleware('admin_api');
Route::put('/news/{news}', [NewsController::class, 'edit'])->name('news_edit')->middleware('admin_api');
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
Route::get('/login', [LoginController::class, 'index'])->name('login_view');

//Admin
Route::get('/admin_board', [AdminController::class, 'index'])->name('admin')->middleware('admin_view');
Route::get('/admin/league/bracket/{league}', [AdminController::class, 'bracket_setup'])->name('bracket_setup')->middleware('admin_view');
Route::get('/admin/league/matchup/{bracket}', [AdminController::class, 'matchup_setup'])->name('matchup_setup')->middleware('admin_view');
Route::get('/admin/league/matchup/{bracket}/{customMatchup}', [AdminController::class, 'matchup_edit'])->name('matchup_edit')->middleware('admin_view');
Route::get('/admin/player/{player}', [AdminController::class, 'player_edit'])->name('player_edit')->middleware('admin_view');
Route::get('/admin/news/{news}', [AdminController::class, 'news_edit'])->name('news_edit_view')->middleware('admin_view');
Route::get('/admin/event/{event}', [AdminController::class, 'event_edit'])->name('event_edit')->middleware('admin_view');
Route::get('/admin/gallery/{gallery}', [AdminController::class, 'gallery_edit'])->name('gallery_edit_view')->middleware('admin_view');

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/mail', [ContactController::class, 'sendEmail'])->name('contact_send_email');

// Membership
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::put('/membership/{membership}', [MembershipController::class, 'edit'])->name('membership_edit')->middleware('admin_api');
Route::post('/membership/mail', [MembershipController::class, 'sendEmail'])->name('membership_send_email');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::post('/events', [EventController::class, 'store'])->name('events_store')->middleware('admin_api');
Route::put('/events/{event}', [EventController::class, 'edit'])->name('events_edit')->middleware('admin_api');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events_destroy')->middleware('admin_api');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events_detail');

//Players
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('player.show');
Route::post('/players', [PlayerController::class, 'store'])->name('players_store')->middleware('admin_api');
Route::put('/players/{player}', [PlayerController::class, 'edit'])->name('players_edit')->middleware('admin_api');
Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players_destroy')->middleware('admin_api');
Route::post('/players/{player_id}/points_add', [PlayerController::class, 'add_points'])->name('players_add_points')->middleware('admin_api');

//Users
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('authenticate');
Route::post('/users/logout', [UserController::class, 'logout'])->name('logout')->middleware('user_api');

//Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery_store')->middleware('admin_api');
Route::put('/gallery/{gallery}', [GalleryController::class, 'edit'])->name('gallery_edit')->middleware('admin_api');
Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery_destroy')->middleware('admin_api');

// Registration
Route::get('/register', [RegistrationController::class, 'showForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Admin user management
Route::post('/admin/users', [RegistrationController::class, 'adminCreate'])
    ->name('admin.users.create')->middleware('admin_api');
Route::post('/admin/users/{user}/approve', [RegistrationController::class, 'approve'])
    ->name('admin.users.approve')->middleware('admin_api');
Route::post('/admin/users/{user}/reject', [RegistrationController::class, 'reject'])
    ->name('admin.users.reject')->middleware('admin_api');
Route::post('/admin/users/{user}/make-admin', [RegistrationController::class, 'makeAdmin'])
    ->name('admin.users.make-admin')->middleware('admin_api');
Route::post('/admin/users/{user}/remove-admin', [RegistrationController::class, 'removeAdmin'])
    ->name('admin.users.remove-admin')->middleware('admin_api');

// Match results
Route::post('/matchups/{matchup}/result', [MatchResultController::class, 'store'])
    ->name('matchups.result.store')->middleware('user_api');
Route::post('/matchups/{matchup}/confirm', [MatchResultController::class, 'confirm'])
    ->name('matchups.result.confirm')->middleware('user_api');
Route::post('/matchups/{matchup}/dispute', [MatchResultController::class, 'dispute'])
    ->name('matchups.result.dispute')->middleware('user_api');
Route::post('/admin/matchups/{matchup}/admin-confirm', [MatchResultController::class, 'adminConfirm'])
    ->name('matchups.admin.confirm')->middleware('admin_api');
Route::post('/admin/matchups/{matchup}/admin-clear', [MatchResultController::class, 'adminClear'])
    ->name('matchups.admin.clear')->middleware('admin_api');

// Comments on news
Route::post('/news/{news}/comments', [CommentController::class, 'storeNews'])
    ->name('news.comments.store')->middleware('user_api');
Route::delete('/news/comments/{comment}', [CommentController::class, 'destroyNews'])
    ->name('news.comments.destroy')->middleware('user_api');

// Comments on events
Route::post('/events/{event}/comments', [CommentController::class, 'storeEvent'])
    ->name('events.comments.store')->middleware('user_api');
Route::delete('/events/comments/{comment}', [CommentController::class, 'destroyEvent'])
    ->name('events.comments.destroy')->middleware('user_api');

// Group chat
Route::get('/brackets/{bracket}/chat/poll', [CommentController::class, 'pollBracket'])
    ->name('brackets.chat.poll')->middleware('user_api');
Route::post('/brackets/{bracket}/chat', [CommentController::class, 'storeBracket'])
    ->name('brackets.chat.store')->middleware('user_api');
Route::delete('/brackets/chat/{comment}', [CommentController::class, 'destroyBracket'])
    ->name('brackets.chat.destroy')->middleware('user_api');
Route::patch('/brackets/chat/{comment}', [CommentController::class, 'updateBracket'])
    ->name('brackets.chat.update')->middleware('user_api');

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications')->middleware('user_view');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
    ->name('notifications.mark-all-read')->middleware('user_api');

// User settings
Route::get('/settings', [UserController::class, 'settings'])->name('settings')->middleware('user_view');
Route::post('/settings/profile', [UserController::class, 'updateProfile'])->name('settings.profile')->middleware('user_api');
Route::post('/settings/password', [UserController::class, 'updatePassword'])->name('settings.password')->middleware('user_api');

// Forgot password info page (no auth needed)
Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');

// Admin: set temporary password
Route::post('/admin/users/{user}/set-password', [RegistrationController::class, 'setTempPassword'])
    ->name('admin.users.set-password')->middleware('admin_api');
Route::post('/admin/users/{user}/link-player', [RegistrationController::class, 'linkPlayer'])
    ->name('admin.users.link-player')->middleware('admin_api');

// Static pages
Route::view('/terms', 'terms.index')->name('terms');

//Exceptions
Route::fallback(function () {
    // Handle 404 errors here
    return response()->view('errors.error-404', [], 404);
});

Route::get('/error/403', function () {
    // Handle 403 errors here
    return view('errors.error-403');
})->name('error403');
