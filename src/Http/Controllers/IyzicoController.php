<?php

namespace Damalis\Iyzico\Http\Controllers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Checkout\Repositories\CartRepository;												
use Webkul\Sales\Repositories\InvoiceRepository;

use Illuminate\Http\Request;

use Damalis\Iyzico\Http\Controllers\IyzicoConfig;

use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
//use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\PayWithIyzicoInitialize;
use Iyzipay\Request\CreatePayWithIyzicoInitializeRequest;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
//use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

class IyzicoController extends Controller
{
    /**
     * OrderRepository $orderRepository
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;
	/**
     * Cart repository instance
     *
     * @var CartRepository
     */
    protected $cartRepository;
    /**
     * InvoiceRepository $invoiceRepository
     *
     * @var \Webkul\Sales\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\OrderRepository  $orderRepository
	 * @param CartRepository $cartRepository
	 * @param InvoiceRepository $invoiceRepository
     * @return void
     */
    public function __construct(OrderRepository $orderRepository,  CartRepository $cartRepository, InvoiceRepository $invoiceRepository)
    {
        $this->orderRepository = $orderRepository;
		$this->cartRepository = $cartRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function checkoutWithIyzico(Request $request)
    {   
        $cart = Cart::getCart();
        $cartbillingAddress = $cart->billing_address;
		
        $checkoutToken = $request->session()->get('_token');
		
        /** @var IyzicoApiClient $api */				
        # create request class
        //$api = new CreateCheckoutFormInitializeRequest();
        $api = new CreatePayWithIyzicoInitializeRequest();											
        $api->setLocale($request->getLocale());
        $api->setConversationId($checkoutToken);
        //$api->setPrice("1");
        //$api->setPaidPrice("1.2");
        $currency = $cart->cart_currency_code;
        if($currency == "TRY") $currency = "TL";
        $api->setCurrency(constant('Iyzipay\Model\Currency::' . $currency));
        $api->setBasketId($cart->id);
        $api->setPaymentGroup(PaymentGroup::PRODUCT);
        $api->setCallbackUrl(request()->getSchemeAndHttpHost() . "/iyzico-payment-callback/" . $checkoutToken);
        //$api->setEnabledInstallments(array(3, 6, 9, 12));
		
        $buyer = new Buyer();
        if( $cartbillingAddress->customer_id ) {
		    $buyer->setId($cartbillingAddress->customer_id);
        } else {
            $buyer->setId($cart->id);
        }
        $buyer->setName($cartbillingAddress->first_name);
        $buyer->setSurname($cartbillingAddress->last_name);
        $buyer->setGsmNumber($cartbillingAddress->phone);
        $buyer->setEmail($cartbillingAddress->email);
        $buyer->setIdentityNumber("74300864791");
        //$buyer->setLastLoginDate(date('Y-m-d H:i:s'));
        //$buyer->setRegistrationDate(date('Y-m-d H:i:s'));
        $buyer->setRegistrationAddress($cartbillingAddress->address);
        $buyer->setIp($request->ip());
        $buyer->setCity($cartbillingAddress->city);
        $buyer->setCountry($cartbillingAddress->country);
        $buyer->setZipCode($cartbillingAddress->postcode);
        $api->setBuyer($buyer);

        $shippingAddress = new Address();
        $shippingAddress->setContactName($cartbillingAddress->first_name . ' ' . $cartbillingAddress->last_name);
        $shippingAddress->setCity($cartbillingAddress->city);
        $shippingAddress->setCountry($cartbillingAddress->country);
        $shippingAddress->setAddress($cartbillingAddress->address);
        $shippingAddress->setZipCode($cartbillingAddress->postcode);		
        /*
        if ( ! $cart->billing_address->use_for_shipping ) {
            $cartshippingAddress = $cart->shipping_address;
            $shippingAddress->setContactName($cartshippingAddress->first_name . ' ' . $cartshippingAddress->last_name);
            $shippingAddress->setCity($cartshippingAddress->city);
            $shippingAddress->setCountry($cartshippingAddress->country);
            $shippingAddress->setAddress($cartshippingAddress->address);
            $shippingAddress->setZipCode($cartshippingAddress->postcode);
        }*/
        $api->setShippingAddress($shippingAddress);		
			
        $billingAddress = new Address();
        $billingAddress->setContactName($cartbillingAddress->name);
        $billingAddress->setCity($cartbillingAddress->city);
        $billingAddress->setCountry($cartbillingAddress->country);
        $billingAddress->setAddress($cartbillingAddress->address);
        $billingAddress->setZipCode($cartbillingAddress->postcode);
        $api->setBillingAddress($billingAddress);
				
        $basketItems = array();
        $amountTotal = 0;                        
        for ($i =0; $i < $cart->items_count; $i++) {
            $BasketItem = new BasketItem();
            $BasketItem->setId($cart->items[$i]->id);
            $BasketItem->setName($cart->items[$i]->name);
            $BasketItem->setCategory1($cart->items[$i]->type);
            $BasketItem->setCategory2('category 2');
            $BasketItem->setItemType(BasketItemType::VIRTUAL);                        
            $BasketItem->setPrice(number_format((float)$cart->items[$i]->base_total, 2, '.', ''));
            $basketItems[$i] = $BasketItem;            
        }
        
        $api->setBasketItems($basketItems);
        $api->setPrice(number_format((float)$cart->sub_total, 2, '.', ''));
        $api->setPaidPrice(number_format((float)$cart->grand_total, 2, '.', ''));
         
        # make request
        //$checkoutFormInitialize = CheckoutFormInitialize::create($api, (new IyzicoConfig)->options());
        $checkoutFormInitialize = PayWithIyzicoInitialize::create($api, (new IyzicoConfig)->options());

        if( $checkoutFormInitialize->getStatus() != "success" ) {
            session()->flash('error', $checkoutFormInitialize->geterrorCode() . ", message: " . $checkoutFormInitialize->geterrorMessage());
            Log::error('Iyzico payment either cancelled or transaction failure.', [
                'conversation_id' => $checkoutFormInitialize->getConversationId,
                'error' => $checkoutFormInitialize->geterrorMessage(),
                'error_code' => $checkoutFormInitialize->geterrorCode()
            ]);
            return redirect()->route('shop.checkout.cart.index'); 
        } else {
            // Store cart id in session for callback
            session(['damalis_cart_id' => $cart->id]);			
            //$request->session()->put('paymentcontent_msg', $checkoutFormInitialize->getCheckoutFormContent());
            //$paymentPageUrl = $checkoutFormInitialize->getPaymentPageUrl();
            $paymentPageUrl = $checkoutFormInitialize->getPayWithIyzicoPageUrl();
            $checkoutFormInitialize->setPaymentPageUrl($paymentPageUrl);																						 
            //$paymentcontent_msg = $checkoutFormInitialize->getCheckoutFormContent();        
            return redirect()->away($paymentPageUrl);
            //return view('iyzico::iyzico-payment-callback')->with(compact('paymentcontent_msg'));
        }
    }

    /**
     * payment callback
     */
	public function paymentCallback(Request $request)
    {   
        try {
            /**
             * @var IyzicoApiClient $api
             */
            $api = new RetrieveCheckoutFormRequest();
            $api->setLocale($request->getLocale());
            $api->setConversationId($request->session()->get('_token'));
            $api->setToken($request->input('token'));
            
            # make request
            $checkoutForm = CheckoutForm::retrieve($api, (new IyzicoConfig)->options());
            
            if(strtolower($checkoutForm->getPaymentStatus()) !== \Iyzipay\Model\Status::SUCCESS) {
                session()->flash('error', 'Iyzico payment either cancelled or transaction failure.');
                Log::error('Iyzico payment either cancelled or transaction failure.', [
                    'conversation_id' => $checkoutForm->getConversationId,
                    'error' => $checkoutForm->getErrorMessage(),
                    'error_code' => $checkoutForm->getErrorCode()
                ]);
                return redirect()->route('shop.checkout.cart.index');                
            }
        } catch (\Exception $e) {
            Log::error('Iyzico', ['error' => $e->getMessage()]);
            throw $e;
        }

        //$cart = Cart::getCart();
        $cart = $this->cartRepository->find(session('damalis_cart_id'));
        $data = (new OrderResource($cart))->jsonSerialize(); // new class v2.2
        $order = $this->orderRepository->create($data);
        //$order = $this->orderRepository->create(Cart::prepareDataForOrder()); // removed for v2.2
        $this->orderRepository->update(['status' => 'processing'], $order->id);
		// Add payment information to order
        $order->payment->update([
            'additional' => array_merge($order->payment->additional ?? [], [
                'damalis_payment_id' => $checkoutForm->getPaymentId() ?? null,
            ]),
        ]);
        if ($order->canInvoice()) {
            $this->invoiceRepository->create($this->prepareInvoiceData($order));
        }
        Cart::deActivateCart();
        session()->flash('order_id', $order->id);
        // Order and prepare invoice
        return redirect()->route('shop.checkout.onepage.success');
    }	
    
    /**
     * Prepares order's invoice data for creation.
     *
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ["order_id" => $order->id,];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
