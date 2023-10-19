<?php

use App\Http\Middleware\VerifyCsrfToken;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
    Route::get('iyzico-payment-checkout',[Damalis\Iyzico\Http\Controllers\IyzicoController::class, 'checkoutWithIyzico'])->name('iyzico.payment.checkout');
    Route::post('iyzico-payment-callback/{token}',[Damalis\Iyzico\Http\Controllers\IyzicoController::class, 'paymentCallback'])->withoutMiddleware(VerifyCsrfToken::class)->name('iyzico.payment.callback'); 
});
