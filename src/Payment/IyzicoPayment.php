<?php

namespace Damalis\Iyzico\Payment;

use Webkul\Payment\Payment\Payment;

class IyzicoPayment extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'iyzico';

    public function getRedirectUrl()
    {
        return route('iyzico.process');
        
    }
}