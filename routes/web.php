<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Livewire\SearchTags;
use App\Http\Livewire\SearchUsersAndTags;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('frontpage');
Route::middleware([
    'auth:sanctum', // ISSUE: https://github.com/404labfr/laravel-impersonate/issues/154
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('doNotCacheResponse');
    Route::resource('tags', TagController::class)->middleware(['can:supadupaadminshit', 'doNotCacheResponse']);
    Route::get('/most-famous-people', [UserController::class, 'most_famous_people'])->name('most-famous-people');
    Route::get('/most-famous-people/{tag}', [UserController::class, 'show_famous_people_by_tag'])->name('most-famous-people-by-tag');
    Route::get('/most-famous-fans', [UserController::class, 'most_famous_fans'])->name('most-famous-fans');
    Route::get('/most-famous-fans/{tag}', [UserController::class, 'show_famous_fans_by_tag'])->name('most-famous-fans-by-tag');
    Route::get('/most-famous-tags', [TagController::class, 'most_famous_tags'])->name('most-famous-tags');
    Route::post('/users/{user}/recount', [UserController::class, 'recount_points'])->name('users.user-recount-points');
    Route::resource('user/statuses', StatusController::class)->middleware('doNotCacheResponse');
    Route::resource('users', UserController::class);
    Route::impersonate();
    Route::get('/search/{stuff?}', SearchUsersAndTags::class)->name('search');
    Route::get('/search-tags/{stuff?}', SearchTags::class)->name('tags.search');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth', 'doNotCacheResponse'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed', 'doNotCacheResponse'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('suggest/{user}', [UserController::class, 'suggest'])->name('suggest');
