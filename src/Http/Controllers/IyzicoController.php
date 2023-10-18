<?php


namespace Damalis\Iyzico\Http\Controllers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Illuminate\Http\Request;

class IyzicoController extends Controller
{
    /**
     * OrderRepository $orderRepository
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;
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
     * @return void
     */
    public function __construct(OrderRepository $orderRepository,  InvoiceRepository $invoiceRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
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
            $api->setConversationId($request->session()->get('tracked_start_checkout'));
            $api->setToken($request->input('token'));
            
            # make request
	        $checkoutForm = CheckoutForm::retrieve($api, (new IyzicoConfig)->options());
            
            if(strtolower($checkoutForm->getPaymentStatus()) !== \Iyzipay\Model\Status::SUCCESS) {
                session()->flash('error', 'Iyzico payment either cancelled or transaction failure.');
				return redirect()->route('shop.checkout.cart.index');                
            }
        } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Iyzico Error : ' . $e->getMessage();
        }

        $order = $this->orderRepository->create(Cart::prepareDataForOrder());
        $this->orderRepository->update(['status' => 'processing'], $order->id);
        if ($order->canInvoice()) {
            $this->invoiceRepository->create($this->prepareInvoiceData($order));
        }
        Cart::deActivateCart();
        session()->flash('order', $order);
        // Order and prepare invoice
        return redirect()->route('shop.checkout.success');
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
