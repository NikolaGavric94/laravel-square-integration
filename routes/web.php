<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Basic charge
Route::get('/charge', 'ChargeController@charge');

Route::group(['prefix' => 'merchant'], function () {
    // Charge with merchant
    Route::get('/{merchant}/charge', 'ChargeController@chargeWithMerchant');
    // Charge with merchant and customer
    Route::get('/{merchant}/customer/{customer}/charge', 'ChargeController@chargeWithMerchantAndCustomer');
});

Route::group(['prefix' => 'customer'], function () {
    // Create customer
    Route::get('/create', 'ChargeController@createCustomer');
    // Charge with customer
    Route::get('/{customer}/charge', 'ChargeController@chargeWithCustomer');
});

Route::group(['prefix' => 'order'], function () {
    // Create an order
    Route::get('/', 'OrderController@order');
    // Order with merchant
    Route::get('/{merchant}/merchant', 'OrderController@orderWithMerchant');
    // Order with customer
    Route::get('/{customer}/customer', 'OrderController@orderWithCustomer');
    // Order with customer and merchant included
    Route::get('/{merchant}/{customer}', 'OrderController@orderWithCustomerAndMerchant');
});