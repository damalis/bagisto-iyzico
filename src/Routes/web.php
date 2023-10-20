<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;

use Damalis\Iyzico\Http\Controllers\IyzicoController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {    
    Route::get('iyzico-payment-checkout', [
        IyzicoController::class, 'checkoutWithIyzico'])->name('iyzico.payment.checkout');    
    Route::post('iyzico-payment-callback/{token}', [
        IyzicoController::class, 'paymentCallback'
    ])->withoutMiddleware(VerifyCsrfToken::class)->name('iyzico.payment.callback'); 
});
