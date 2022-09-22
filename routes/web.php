<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageHandler;

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

Route::get('/tmasigns/jpg/{size}/{text}/', [ImageHandler::class, 'jpg']);
Route::get('/tmasigns/zip/{size}/{text}/', [ImageHandler::class, 'zip']);

Route::get('/phpinfo', function () { phpinfo();});
