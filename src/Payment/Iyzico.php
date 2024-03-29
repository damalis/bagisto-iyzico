<?php

namespace Damalis\Iyzico\Payment;

use Webkul\Payment\Payment\Payment;

class Iyzico extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'iyzico';

    /**
    * Get redirect url.
    *
    * @var string
    */
    public function getRedirectUrl()
    {
        return route('iyzico.payment.checkout');        
    }
}
