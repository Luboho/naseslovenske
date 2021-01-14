<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Auth::routes();

// Temporary Log out route
Route::get('/logout-manual', function() {
    request()->session()->invalidate();
});


Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
