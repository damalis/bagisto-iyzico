<?php

namespace Damalis\Iyzico\Http\Controllers;

use Iyzipay\Options;

class IyzicoConfig
{

    public function options()
    {
        $options = new Options();
        $public = core()->getConfigData('sales.payment_methods.iyzico.public_key');
        $secret = core()->getConfigData('sales.payment_methods.iyzico.secret_key');
        $options->setApiKey($public);
        $options->setSecretKey($secret);
        
        $baseUrl = $this->environment();
        $options->setBaseUrl($baseUrl);
        
        return $options;
    }

    /**
     * Setting up and Returns İyzico SDK environment with İyzico Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
	public function environment()
    { 
        $iyzicoMode = core()->getConfigData('sales.payment_methods.iyzico.sandbox');

        if ($iyzicoMode) {			
            return "https://sandbox-api.iyzipay.com";
        }

        return "https://api.merchant.iyzico.com";
    }
}