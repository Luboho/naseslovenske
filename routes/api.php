<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;

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

Route::get('/profiles', [ProfilesController::class, 'index']);
Route::get('/profiles/{profile}', [ProfilesController::class, 'show']);

Route::middleware('auth:api')->group(function() {
    Route::post('/profiles', [ProfilesController::class, 'store']);
    Route::patch('/profiles/{profile}/', [ProfilesController::class, 'update']);
    Route::delete('/profiles/{profile}', [ProfilesController::class, 'destroy']);
});


