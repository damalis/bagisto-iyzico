<?php

Route::group([
    //'prefix'     => 'iyzico/payment',
    'middleware' => ['web', 'theme', 'locale', 'currency']
   ], function () {

       Route::get('iyzico-payment-redirect','Damalis\Iyzico\Providers\HookServiceProvider@checkoutWithIyzico')->name('iyzico.process');
       Route::post('iyzico-payment-callback','Damalis\Iyzico\Http\Controllers\IyzicoController@paymentCallback')->name('iyzico.callback'); 
});
