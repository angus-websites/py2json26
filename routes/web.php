<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('public.home');
})->name('home');

// System information
Route::get('/version', [SystemController::class, 'version']);
Route::get('/info', [SystemController::class, 'info']);
