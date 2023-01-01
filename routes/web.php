<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TMASignsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Statamic\Statamic;

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

/* Public pages */

Route::get('/', [PageController::class, 'home'])
    ->name('home');

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts');
Route::get('/post/{slug}', [PostController::class, 'show'])
    ->name('post.slug');
Route::redirect('/post', '/posts', 301);
Route::get('/tags/{tag}', [PostController::class, 'tags'])
    ->name('post.slug');

Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact');

Route::get('/tmasigns', [PageController::class, 'tmasigns'])
    ->name('tmasigns');

/* Public pages */

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('auth.dashboard');

    Route::get('/logout', function () {
        Auth::logout();
        // Request::session()->invalidate();
        // Request::session()->regenerateToken();
        return redirect(route('login'));
    })->name('auth.logout');

    Route::get('tmasigns/bigbatch', [TMASignsController::class, 'bigbatch']);

    Route::view('/background', 'background', ['aspectratio' => Request::query('aspectratio', '16 / 9')]);
});

Statamic::pushWebRoutes(function () {
    Route::redirect('/cp/auth/login', '/login');
});
