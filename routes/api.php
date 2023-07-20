<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('posts')->group( function() {
    Route::get('/', [\App\Http\Controllers\PostController::class, 'index']);
    Route::delete('/{post}', [\App\Http\Controllers\PostController::class, 'delete'])
        ->missing(function () {
            return response()->json([
                'status' => false,
                'message' => 'Post not found!'
            ], 404);
        });
});

Route::prefix('comments')->group( function () {
    Route::get('/', [\App\Http\Controllers\CommentController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\CommentController::class, 'store']);
    Route::delete('/{comment}', [\App\Http\Controllers\CommentController::class, 'delete'])
        ->missing(function () {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found!'
            ], 404);
    });
});
