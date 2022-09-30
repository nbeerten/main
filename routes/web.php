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
    return view('home');
})->name('home');

Route::middleware(['throttle:tmasigns'])->group(function () {
    Route::get('/tmasigns/jpg/{size}/{text}/{subtext?}', [TMASignsController::class, 'jpg']);
    Route::get('/tmasigns/zip/{size}/{text}/{subtext?}', [TMASignsController::class, 'zip']);

    Route::get('/tmasigns', function () {
        return view('pages.tmasigns');
    })->name('tmasigns');
});
