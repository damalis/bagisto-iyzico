<?php

namespace Damalis\Iyzico\Listeners;

use Damalis\Iyzico\Http\Controllers\IyzicoConfig;
//use Iyzipay\Model\Refund as RefundModel;
use Iyzipay\Model\AmountBaseRefund as RefundModel;
//use Iyzipay\Request\CreateRefundRequest;
use Iyzipay\Request\AmountBaseRefundRequest;
use Iyzipay\Options;

use Illuminate\Support\Facades\Log;

use Webkul\Admin\Listeners\Base;

class IyzicoRefund extends Base
{
    /**
     * After Refund is created
     */
    public function afterCreated(\Webkul\Sales\Contracts\Refund $refund): void
    {
        try {
            $order = $refund->order;
			if ($order->payment->method === 'iyzico') {
				if ($refund->total_qty > 0) {
					$refundRequest = new AmountBaseRefundRequest();//new CreateRefundRequest();
					$refundRequest->setIp(request()->ip());
					$refundRequest->setPrice($refund->grand_total);
					$refundRequest->setPaymentId($order->payment->additional['damalis_payment_id']);
					$refundRequest->setLocale(app()->getLocale());
					//$request->setCurrency($refund->order_currency_code);
					$refundModel = RefundModel::create($refundRequest, (new IyzicoConfig)->options());
					//dd($refundModel);
					if( $refundModel->getStatus() === "failure" ) {
						Log::error('Iyzico, Refund processe failed', [
							'payment_id' => $order->payment->additional['damalis_payment_id'],
							'error' => $refundModel->getErrorMessage(),
							'error_code' => $refundModel->getErrorCode()
						]);
					} else {
						Log::info('Iyzico, Refund processed successfully.', ['refund_id' => $refund->id]);
					}
				}
			}
		} catch (\Exception $e) {
			Log::error('Refund processe failed.', ['error' => $e->getMessage()]);
            throw $e;
		}
    }
}
