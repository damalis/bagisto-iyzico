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
	
	/**
     * Returns payment method image
     *
     * @return array
     *//*
    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/iyzico.png', 'shop');

    }*/
}