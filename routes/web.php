<?php

use App\Http\Controllers\ContactFormController;
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

/* Add CSP header to all public pages */
Route::middleware(Spatie\Csp\AddCspHeaders::class)->group(function () {
    Route::get('/', [PageController::class, 'home'])
        ->name('home');

    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts');
    Route::get('/post/{slug}', [PostController::class, 'show'])
        ->name('post.slug');
    Route::redirect('/post', '/posts', 301);
    Route::get('/tags/{slug}', [PostController::class, 'tags'])
        ->name('tags.slug');

    Route::get('/contact', [PageController::class, 'contact'])
        ->name('contact');

    Route::post('/contact', [ContactFormController::class, 'post'])
        ->name('contact.post');

    Route::get('/tmasigns', [PageController::class, 'tmasigns'])
        ->name('tmasigns');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('auth.dashboard');
        })->name('auth.dashboard');

        Route::get('/logout', function () {
            Auth::logout();

            return redirect(route('login'));
        })->name('auth.logout');

        Route::get('tmasigns/bigbatch', [TMASignsController::class, 'bigbatch']);

        Route::view('/background', 'background', ['aspectratio' => Request::query('aspectratio', '16 / 9')]);
    });
});

Statamic::pushWebRoutes(function () {
    Route::redirect('/cp/auth/login', '/login');
});
