<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\SearchTags;
use App\Livewire\SearchUsersAndTags;
use App\Livewire\UploadCelebs;
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
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('tags', TagController::class)->middleware(['can:supadupaadminshit']);
    Route::get('/most-famous-people', [UserController::class, 'most_famous_people'])->name('most-famous-people')->middleware('cacheResponse');
    Route::get('/most-famous-people/{tag}', [UserController::class, 'show_famous_people_by_tag'])->name('most-famous-people-by-tag')->middleware('cacheResponse');
    Route::get('/most-famous-fans', [UserController::class, 'most_famous_fans'])->name('most-famous-fans')->middleware('cacheResponse');
    Route::get('/most-famous-fans/{tag}', [UserController::class, 'show_famous_fans_by_tag'])->name('most-famous-fans-by-tag')->middleware('cacheResponse');
    Route::get('/most-famous-tags', [TagController::class, 'most_famous_tags'])->name('most-famous-tags')->middleware('cacheResponse');
    Route::post('/users/{user}/recount', [UserController::class, 'recount_points'])->name('users.user-recount-points');
    Route::resource('user/statuses', StatusController::class);
    Route::resource('users', UserController::class);
    Route::impersonate();
    Route::get('/search/{stuff?}', SearchUsersAndTags::class)->name('search')->middleware('cacheResponse');
    Route::get('/search-tags/{stuff?}', SearchTags::class)->name('tags.search')->middleware('cacheResponse');
    Route::get('/upload-celebs', UploadCelebs::class)->name('upload-celebs')->middleware('can:supadupaadminshit');
});
Route::get('suggest/{user}', [UserController::class, 'suggest'])->name('suggest')->middleware('cacheResponse');
Route::get('cookie-policy', [WelcomeController::class, 'cookie_policy'])->name('cookies')->middleware('cacheResponse');
Route::get('info', [WelcomeController::class, 'info'])->name('info')->middleware('cacheResponse');
