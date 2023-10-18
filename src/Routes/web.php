<?php

use Illuminate\Support\Facades\Route;

use Damalis\Iyzico\Providers;
use Damalis\Iyzico\Http\Controllers;

/*
Route::group(['middleware' => ['web', 'admin']], function () {
    Route::get('iyzico-payment-redirect','Damalis\Iyzico\Providers\HookServiceProvider@checkoutWithIyzico')->name('iyzico.process');
    Route::post('iyzico-payment-callback','Damalis\Iyzico\Http\Controllers\IyzicoController@paymentCallback')->name('iyzico.callback'); 
});
*/

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
    Route::get('iyzico-payment-checkout',[HookServiceProvider::class, 'checkoutWithIyzico'])->name('iyzico.checkout');
    Route::post('iyzico-payment-callback',[IyzicoController::class, 'paymentCallback'])->name('iyzico.callback'); 
});
