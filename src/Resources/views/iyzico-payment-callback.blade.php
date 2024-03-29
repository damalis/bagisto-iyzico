<x-shop::layouts.account>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('iyzico::app.admin.system.iyzicoPayment')
    </x-slot:title>

    <div class="flex justify-between items-center">
        <h2 class="text-[26px] font-medium">
            @section('page_title')
				{{ __('Iyzico Checkout....') }}
			@stop

			@push('scripts')
				<?php echo $paymentcontent_msg; ?>
			@endpush
        </h2>
    </div>
</x-shop::layouts.account>
