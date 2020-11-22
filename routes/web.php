<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Auth::routes();

// Temporay logout route
// Route::get('/logout-manual', function() {
//     request()->session()->invalidate();
// });

// Temporary Log out route
Route::get('/logout-manual', function() {
    request()->session()->invalidate();
});


Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
