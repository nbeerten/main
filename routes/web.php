<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TMASignsController;
use App\Http\Controllers\OpengraphImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

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

// Main pages
Route::get('/', [HomeController::class, 'show'])->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::redirect('/post', '/posts', 301);
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.slug');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/tmasigns', function () {
    return view('tmasigns');
})->name('tmasigns');

// Small services
Route::get('/og', [OpengraphImageController::class, 'get'])
     ->name('og');

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