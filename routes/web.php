<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TMASignsController;
use App\Http\Controllers\OpengraphImageController;
use App\Http\Controllers\PostViewController;

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
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/tmasigns', function () {
    return view('tmasigns');
})->name('tmasigns');

// Small services
Route::get('/og', [OpengraphImageController::class, 'get'])
     ->name('og');

// Authentication
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