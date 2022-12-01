<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Livewire\SearchUsersAndTags;

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
    //'auth:sanctum', https://github.com/404labfr/laravel-impersonate/issues/154
    'auth:web',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('tags', TagController::class);
    Route::get('/most-famous-people', [UserController::class, 'most_famous_people'])->name('users.most-famous-people');
    Route::get('/most-famous-people/{tag}', [UserController::class, 'show_famous_people_by_tag'])->name('users.most-famous-people.show');
    Route::get('/most-famous-fans', [UserController::class, 'most_famous_fans'])->name('users.most-famous-fans');
    Route::get('/most-famous-fans/{tag}', [UserController::class, 'show_famous_fans_by_tag'])->name('users.most-famous-fans.show');
    Route::resource('users', UserController::class);
    Route::impersonate();
    Route::get('/search/{stuff?}', SearchUsersAndTags::class)->name('search');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');