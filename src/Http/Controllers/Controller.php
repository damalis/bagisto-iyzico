<?php

namespace Damalis\Iyzico\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Damalis\Iyzico\Http\Controllers\IyzicoConfig;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\Locale;
use Iyzipay\Options;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
