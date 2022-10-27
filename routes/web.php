<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TMASignsController;

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

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/tmasigns', function () {
    return view('pages.tmasigns');
})->name('tmasigns');

Route::get('/login', function () {
    if(Auth::check()) return redirect(route('auth.dashboard'));
    else return view('auth.login');
})->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('auth.dashboard');

    Route::get('/logout', function () {
        Auth::logout();
        Request::session()->invalidate();
        Request::session()->regenerateToken();
        return redirect(route('auth.login'));
    })->name('auth.logout');
});

// Routes which need authentication
Route::middleware('auth')->group(function () {
    Route::get('tmasigns/batch/{size}', [TMASignsController::class, 'batch']);
});