<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Temporary Log out route
Route::get('/logout-manual', function() {
    request()->session()->invalidate();
});

Route::middleware('auth:api')->group(function() {
    Route::get('/posts', [PostsController::class, 'index']);
    Route::post('/posts', [PostsController::class, 'store']);
    // Route::get('/posts/{post}', [PostsController::class, 'show']);
    // Route::patch('/posts/{post}', [PostsController::class, 'update']);
    // Route::delete('/posts/{post}', [PostsController::class, 'destroy']);
});


