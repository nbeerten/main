<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

/* Add CSP header to all public pages */
Route::middleware(Spatie\Csp\AddCspHeaders::class)->group(function () {
    Route::get('/', [PageController::class, 'home'])
        ->name('home');

    Route::get('/contact', [PageController::class, 'contact'])
        ->name('contact');

    Route::post('/contact', [ContactFormController::class, 'post'])
        ->name('contact.post');

    Route::get('/tmasigns', [PageController::class, 'tmasigns'])
        ->name('tmasigns');

    Route::get('/login', [AuthController::class, 'login'])
        ->middleware('guest')->name('login');

    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])
        ->middleware('guest')->name('password.request');

    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])
        ->middleware('guest')->name('password.reset');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/logout', function () {
            Auth::logout();

            return redirect(route('login'));
        })->name('logout');
    });
});