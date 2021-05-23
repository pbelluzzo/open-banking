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

Route::middleware('auth:api')->group(function() {
    
    Route::get('/clients', 'ClientsController@index');
    Route::post('/clients', 'ClientsController@store');
    Route::get('/clients/{client}', 'ClientsController@show');
    Route::patch('/clients/{client}', 'ClientsController@update');
    Route::delete('/clients/{client}', 'ClientsController@destroy');

    Route::get('/financial_institutions', 'FinancialInstitutionsController@index');
    Route::post('/financial_institutions', 'FinancialInstitutionsController@store');
    Route::get('/financial_institutions/{financial_institution}','FinancialInstitutionsController@show');
    Route::patch('/financial_institutions/{financial_institution}', 'FinancialInstitutionsController@update');
    Route::delete('/financial_institutions/{financial_institution}', 'FinancialInstitutionsController@destroy');
    
    Route::get('/accounts', 'AccountsController@index');
    Route::post('/accounts', 'AccountsController@store');
    Route::get('/accounts/{account}', 'AccountsController@show');
    Route::patch('/accounts/{account}', 'AccountsController@update');
    Route::delete('/accounts/{account}', 'AccountsController@destroy');
    
    Route::get('/financial_products', 'FinancialProductsController@index');
    Route::post('/financial_products', 'FinancialProductsController@store');
    Route::get('/financial_products/{financial_product}', 'FinancialProductsController@show');
    Route::patch('/financial_products/{financial_product}', 'FinancialProductsController@update');
    Route::delete('/financial_products/{financial_product}', 'FinancialProductsController@destroy');
    
    Route::get('/contracts', 'ContractsController@index');
    Route::post('/contracts', 'ContractsController@store');
    Route::get('/contracts/{contract}', 'ContractsController@show');
    Route::patch('/contracts/{contract}', 'ContractsController@update');
    Route::delete('/contracts/{contract}', 'ContractsController@destroy');
    
    Route::get('/sharings', 'SharingsController@index');
    Route::post('/sharings', 'SharingsController@store');
    Route::get('/sharings/{sharing}', 'SharingsController@show');
    Route::patch('/sharings/{sharing}', 'SharingsController@update');
    Route::delete('/sharings/{sharing}', 'SharingsController@destroy');
    Route::get('/sharings/download/{sharing}', 'SharingsController@download');
});
