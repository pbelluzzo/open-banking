<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any','.*');