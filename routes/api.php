<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')->group(function() {
    
    Route::post('/clients', 'ClientsController@store');
    Route::get('/clients/{client}', 'ClientsController@show');
    Route::patch('/clients/{client}', 'ClientsController@update');
    Route::delete('/clients/{client}', 'ClientsController@destroy');

    Route::post('/financial_institutions', 'FinancialInstitutionsController@store');
    Route::get('/financial_institutions/{financial_institution}','FinancialInstitutionsController@show');
    Route::patch('/financial_institutions/{financial_institution}', 'FinancialInstitutionsController@update');
    Route::delete('/financial_institutions/{financial_institution}', 'FinancialInstitutionsController@destroy');
    
    Route::post('/accounts', 'AccountsController@store');
    Route::get('/accounts/{account}', 'AccountsController@show');
    Route::patch('/accounts/{account}', 'AccountsController@update');
    Route::delete('/accounts/{account}', 'AccountsController@destroy');
    
    Route::post('/financial_products', 'FinancialProductsController@store');
    Route::get('/financial_products/{financial_product}', 'FinancialProductsController@show');
    Route::patch('/financial_products/{financial_product}', 'FinancialProductsController@update');
    Route::delete('/financial_products/{financial_product}', 'FinancialProductsController@destroy');
    
    Route::post('/contracts', 'ContractsController@store');
    Route::get('/contracts/{contract}', 'ContractsController@show');
    Route::patch('/contracts/{contract}', 'ContractsController@update');
    Route::delete('/contracts/{contract}', 'ContractsController@destroy');
    
    Route::post('/sharings', 'SharingsController@store');
    Route::get('/sharings/{sharing}', 'SharingsController@show');
    Route::patch('/sharings/{sharing}', 'SharingsController@update');
    Route::delete('/sharings/{sharing}', 'SharingsController@destroy');
});
