<?php

//use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/logout-manually', function (){
    request()->session()->invalidate();
});

Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any','.*');