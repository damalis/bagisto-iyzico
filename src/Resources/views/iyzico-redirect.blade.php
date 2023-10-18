@extends('shop::layouts.master')

@section('page_title')
    {{ __('Iyzico Checkout....') }}
@stop

@push('scripts')
<?php echo $paymentcontent_msg ?>;
@endpush