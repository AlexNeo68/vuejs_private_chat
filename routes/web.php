<?php

use App\Http\Controllers\Api\Friends\FriendController;
use App\Http\Controllers\Api\Session\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::get('/friends', [FriendController::class, 'index']);

    Route::post('/sessions', [SessionController::class, 'store']);
});
