<?php

namespace Damalis\Iyzico\Providers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Illuminate\Http\Request;

use Damalis\Iyzico\Http\Controllers\IyzicoConfig;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

class HookServiceProvider extends ServiceProvider
{
    public function checkoutWithIyzico(array $data, Request $request)
    {
		$cart = Cart::getCart();
        $billingAddress = $cart->billing_address;

        $shipping_rate = $cart->selected_shipping_rate ? $cart->selected_shipping_rate->price : 0; // shipping rate
        $discount_amount = $cart->discount_amount; // discount amount
        $total_amount =  ($cart->sub_total + $cart->tax_total + $shipping_rate) - $discount_amount; // total amount
		
		$checkoutToken = $request->input('checkout-token');
		
		/** @var IyzicoApiClient $api */				
		# create request class
		$api = new CreateCheckoutFormInitializeRequest();
		$api->setLocale($request->getLocale());
		$api->setConversationId($checkoutToken);
		//$api->setPrice("1");
		//$api->setPaidPrice("1.2");
        $currency = $request->input('currency');
        if($currency == "TRY") $currency = "TL";
		$api->setCurrency(constant('Iyzipay\Model\Currency::' . $currency));
		$api->setBasketId($cart->id);
		$api->setPaymentGroup(PaymentGroup::PRODUCT);
		$api->setCallbackUrl(request()->getSchemeAndHttpHost() . "/iyzico/payment/callback/" . $checkoutToken);
		$api->setEnabledInstallments(array(2, 3, 6, 9));
		
		$buyer = new Buyer();
        $request->session()->put('customer_id', $request->input('customer_id'));
        $request->session()->put('customer_type', $request->input('customer_type'));
        $customerId = $request->input('customer_id');
        if(! $customerId ) $customerId = $checkoutToken;
		$buyer->setId($customerId);
		$buyer->setName($billingAddress->name);
		$buyer->setSurname($billingAddress->name);
		$buyer->setGsmNumber($billingAddress->phone);
		$buyer->setEmail($billingAddress->email);
		$buyer->setIdentityNumber("74300864791");
		$buyer->setLastLoginDate(date('Y-m-d H:i:s'));
		$buyer->setRegistrationDate(date('Y-m-d H:i:s'));
		$buyer->setRegistrationAddress($billingAddress->address);
		$buyer->setIp($request->ip());
		//$buyer->setCity($request->input('address')['city']);
		//$buyer->setCountry($request->input('address')['country']);
		//$buyer->setZipCode("34732");
		$api->setBuyer($buyer);
			
		$shippingAddress = new Address();
		$shippingAddress->setContactName($billingAddress->name);
		$shippingAddress->setCity($request->input('address')['city']);
		$shippingAddress->setCountry($request->input('address')['country']);
		$shippingAddress->setAddress($billingAddress->address);
		//$shippingAddress->setZipCode("34742");
		$api->setShippingAddress($shippingAddress);
			
		$billingAddress = new Address();
		$billingAddress->setContactName($billingAddress->name);
		$billingAddress->setCity($request->input('address')['city']);
		$billingAddress->setCountry($request->input('address')['country']);
		$billingAddress->setAddress($billingAddress->address);
		//$billingAddress->setZipCode("34742");
		$api->setBillingAddress($billingAddress);
				
		$basketItems = array();
        $amountTotal = 0;                
        $i = 0;
        foreach ($groupedProducts as $grouped) {
            foreach($grouped['products'] as $product) {
                $BasketItem = new BasketItem();
                $BasketItem->setId($product->original_product->id);
                $BasketItem->setName($product->original_product->name);
                $BasketItem->setCategory1($storeName);
                $BasketItem->setCategory2('category 2');
                $BasketItem->setItemType(BasketItemType::VIRTUAL);
                $BasketItem->setPrice(number_format((float)$paymentData['products'][$i]['price_per_order'], 2, '.', ''));                    
                $basketItems[$i] = $BasketItem;
                        
                $i++;
            }
        }

        $api->setBasketItems($basketItems);
        $api->setPrice(number_format((float)$total_amount, 2, '.', ''));
        $api->setPaidPrice(number_format((float)$total_amount, 2, '.', ''));
                
        # make request
        $checkoutFormInitialize = CheckoutFormInitialize::create($api, (new IyzicoConfig)->options());
                
        //$request->session()->put('paymentcontent_msg', $checkoutFormInitialize->getCheckoutFormContent());
		$paymentcontent_msg = $checkoutFormInitialize->getCheckoutFormContent();
        return view('iyzico::redirect')->with(compact('paymentcontent_msg'));
    }
}
