<?php

namespace Damalis\Iyzico\Listeners;

use Damalis\Iyzico\Http\Controllers\IyzicoConfig;

use Iyzipay\Model\Cancel as CancelModel;
use Iyzipay\Request\CreateCancelRequest;
use Iyzipay\Options;

use Illuminate\Support\Facades\Log;

use Webkul\Admin\Listeners\Base;

class IyzicoCancel extends Base
{
    /**
     * After Cancel is created
     */
    public function afterCanceled(\Webkul\Sales\Contracts\Order $cancel): void
    {
        try {
            dd($cancel);
			if ($cancel->payment->method === 'iyzico') {
				if ($cancel->total_qty > 0) {
					$request = new CreateCancelRequest();
					$request->setIp(request()->ip());					
					$request->setPaymentId($order->payment->additional['damalis_payment_id']);
					$request->setLocale(app()->getLocale());					
					$cancelModel = CancelModel::create($request, (new IyzicoConfig)->options());
					//dd($cancelModel);
					if( $cancelModel->getStatus() === "failure" ) {
						Log::error("Iyzico, Cancel processe failed", [
							'payment_id' => $order->payment->additional['damalis_payment_id'],
							'error' => $cancelModel->getErrorMessage(),
							'error_code' => $cancelModel->getErrorCode()
						]);
					} else {
						session()->flash('success', 'Iyzico, Cancel processed successfully.');
						Log::info('Iyzico, Cancel processed successfully.', ['cancel_id' => $cancel->id]);
					}
				}
			}
		} catch (\Exception $e) {
			Log::error('Cancel processed failed.', ['error' => $e->getMessage()]);
			throw $e;
		}
    }
}
