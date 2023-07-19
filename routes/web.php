<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('posts')->group( function() {

    Route::get('/', [\App\Http\Controllers\PostController::class, 'index']);
});

Route::prefix('comments')->group( function () {

    Route::get('/', [\App\Http\Controllers\CommentController::class, 'index']);
});
