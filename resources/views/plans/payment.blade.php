@extends('layouts.admin')

@section('page-title') {{__('Payment')}} @endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-5 mb-1">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs">
                            @if(isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#stripe-billing" class="active">{{ __('Stripe') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#paypal-billing">{{ __('Paypal') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#paystack-billing">{{ __('Paystack') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#flutterwave-billing">{{ __('Flutterwave') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#razorpay-billing">{{ __('Razorpay') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#paytm-billing">{{ __('Paytm') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#mercado-billing">{{ __('Mercado') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#mollie-billing">{{ __('Mollie') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#skrill-billing">{{ __('Skrill') }}</a>
                                </li>
                            @endif
                            @if(isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on')
                                <li>
                                    <a data-toggle="tab" href="#coingate-billing">{{ __('Coingate') }}</a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content mt-3">
                            @if(isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on')
                                <div id="stripe-billing" class="tab-pane in active">
                                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" id="stripe-payment-form">
                                        @csrf
                                        <div class="py-3 stripe-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="stripe_payment_frequency" class="payment_frequency" data-from="stripe" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="stripe_payment_frequency" class="payment_frequency" data-from="stripe" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle mt-1 w-100" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="payment_type" id="one_time_type" value="one-time" autocomplete="off" checked="">
                                                            {{ __('One Time') }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="payment_type" id="recurring_type" value="recurring" autocomplete="off">
                                                            {{ __('Reccuring') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="stripe_coupon" name="coupon" class="form-control coupon" data-from="stripe" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="stripe">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_stripe">
                                                        {{__('Checkout')}} (<span class="coupon-stripe">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on')
                                <div id="paypal-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.paypal') }}" method="post" class="require-validation" id="paypal-payment-form">
                                        @csrf
                                        <div class="py-3 paypal-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="paypal_payment_frequency" class="payment_frequency" data-from="paypal" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="paypal_payment_frequency" class="payment_frequency" data-from="paypal" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="paypal_coupon" name="coupon" class="form-control coupon" data-from="paypal" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="paypal">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_paypal">
                                                        {{__('Checkout')}} (<span class="coupon-paypal">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on')
                                <div id="paystack-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.paystack') }}" method="post" class="require-validation" id="paystack-payment-form">
                                        @csrf
                                        <div class="py-3 paystack-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="paystack_payment_frequency" class="payment_frequency" data-from="paystack" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="paystack_payment_frequency" class="payment_frequency" data-from="paystack" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="paystack_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="paystack">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="button" id="pay_with_paystack">
                                                        {{__('Checkout')}} (<span class="coupon-paystack">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on')
                                <div id="flutterwave-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.flaterwave') }}" method="post" class="require-validation" id="flaterwave-payment-form">
                                        @csrf
                                        <div class="py-3 paypal-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="flaterwave_payment_frequency" class="flaterwave_frequency payment_frequency" data-from="flaterwave" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="flaterwave_payment_frequency" class="flaterwave_frequency payment_frequency" data-from="flaterwave" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="flaterwave_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="flaterwave">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="button" id="pay_with_flaterwave">
                                                        {{__('Checkout')}} (<span class="coupon-flaterwave">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on')
                                <div id="razorpay-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.razorpay') }}" method="post" class="require-validation" id="razorpay-payment-form">
                                        @csrf
                                        <div class="py-3 paypal-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="razorpay_payment_frequency" class="razorpay_frequency payment_frequency" data-from="razorpay" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="razorpay_payment_frequency" class="razorpay_frequency payment_frequency" data-from="razorpay" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="razorpay_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="razorpay">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="button" id="pay_with_razorpay">
                                                        {{__('Checkout')}} (<span class="coupon-razorpay">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on')
                                <div id="paytm-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.paytm') }}" method="post" class="require-validation" id="paytm-payment-form">
                                        @csrf
                                        <div class="py-3 paypal-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="paytm_payment_frequency" class="paytm_frequency payment_frequency" data-from="paytm" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="paytm_payment_frequency" class="paytm_frequency payment_frequency" data-from="paytm" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-11">
                                                    <div class="form-group">
                                                        <label for="flaterwave_coupon" class="form-control-label text-dark">{{__('Mobile Number')}}</label>
                                                        <input type="text" id="mobile" name="mobile" class="form-control mobile" data-from="mobile" placeholder="{{ __('Enter Mobile Number') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="paytm_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="paytm">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_paytm">
                                                        {{__('Checkout')}} (<span class="coupon-paytm">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on')
                                <div id="mercado-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.mercado') }}" method="post" class="require-validation" id="mercado-payment-form">
                                        @csrf
                                        <div class="py-3 mercado-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="mercado_payment_frequency" class="mercado_frequency payment_frequency" data-from="mercado" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="mercado_payment_frequency" class="mercado_frequency payment_frequency" data-from="mercado" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="mercado_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="mercado">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_paytm">
                                                        {{__('Checkout')}} (<span class="coupon-mercado">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on')
                                <div id="mollie-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.mollie') }}" method="post" class="require-validation" id="mollie-payment-form">
                                        @csrf
                                        <div class="py-3 mercado-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="mollie_payment_frequency" class="mollie_frequency payment_frequency" data-from="mollie" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="mollie_payment_frequency" class="mollie_frequency payment_frequency" data-from="mollie" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="mollie_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="mollie">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_mollie">
                                                        {{__('Checkout')}} (<span class="coupon-mollie">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on')
                                <div id="skrill-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.skrill') }}" method="post" class="require-validation" id="skrill-payment-form">
                                        @csrf
                                        <div class="py-3 skrill-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="skrill_payment_frequency" class="skrill_frequency payment_frequency" data-from="skrill" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="skrill_payment_frequency" class="skrill_frequency payment_frequency" data-from="skrill" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="skrill_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="skrill">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $skrill_data = [
                                                    'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                    'user_id' => 'user_id',
                                                    'amount' => 'amount',
                                                    'currency' => 'currency',
                                                ];
                                                session()->put('skrill_data', $skrill_data);
                                            @endphp
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_skrill">
                                                        {{__('Checkout')}} (<span class="coupon-skrill">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if(isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on')
                                <div id="coingate-billing" class="tab-pane">
                                    <form role="form" action="{{ route('plan.pay.with.coingate') }}" method="post" class="require-validation" id="coingate-payment-form">
                                        @csrf
                                        <div class="py-3 coingate-payment-div">
                                            <div class="row">
                                                <div class="col-12 pb-3">
                                                    <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-primary active">
                                                            <input type="radio" name="coingate_payment_frequency" class="coingate_frequency payment_frequency" data-from="coingate" value="monthly" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}" autocomplete="off" checked="">{{ __('Monthly Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->monthly_price }}
                                                        </label>
                                                        <label class="btn btn-sm btn-primary">
                                                            <input type="radio" name="coingate_payment_frequency" class="coingate_frequency payment_frequency" data-from="coingate" value="annual" data-price="{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}" autocomplete="off">{{ __('Annual Payments') }}<br>
                                                            {{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') . $plan->annual_price }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" id="coingate_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-1">
                                                        <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white apply-coupon" data-from="coingate">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="text-sm-right">
                                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                    <button class="btn badge-blue btn-xs rounded-pill px-3" type="submit" id="pay_with_coingate">
                                                        {{__('Checkout')}} (<span class="coupon-coingate">{{ $plan->price }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('.nav-tabs li a').first().trigger('click');
            }, 100);
        });
    </script>
    <script src="{{url('assets/js/jquery.form.js')}}"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


   @if(!empty($paymentSetting['is_stripe_enabled']) && isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on')
    <?php $stripe_session = \Session::get('stripe_session');?>

    <?php if(isset($stripe_session) && $stripe_session): ?>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe('{{ $paymentSetting['stripe_key'] }}');
        stripe.redirectToCheckout({
            sessionId: '{{ $stripe_session->id }}',
        }).then((result) => {
        });
    </script>
    <?php endif ?>
    @endif


    <script type="text/javascript">
        $(document).on('change', '.payment_frequency', function (e) {
            var price = $(this).attr('data-price');
            var where = $(this).attr('data-from');
            $('.coupon-' + where).text(price);

            if ($('#' + where + '_coupon').val() != null && $('#' + where + '_coupon').val() != '') {
                applyCoupon($('#' + where + '_coupon').val(), where);
            }
        });

        // Apply Coupon
        $(document).on('click', '.apply-coupon', function (e) {
            e.preventDefault();

            var ele = $(this);
            var coupon = $('#' + ele.attr('data-from') + '_coupon').val();

            applyCoupon(coupon, ele.attr('data-from'));
        });

        function applyCoupon(coupon_code, where) {
            if (coupon_code != null && coupon_code != '') {
                $.ajax({
                    url: '{{route('apply.coupon')}}',
                    datType: 'json',
                    data: {
                        plan_id: '{{ $plan->id }}',
                        coupon: coupon_code,
                        frequency: $('input[name="' + where + '_payment_frequency"]:checked').val()
                    },
                    success: function (data) {
                        if (data.is_success) {
                            $('.coupon-' + where).text(data.final_price);
                        } else {
                            $('.final-price').text(data.final_price);
                            show_toastr('Error', data.message, 'error');
                        }
                    }
                })
            } else {
                show_toastr('Error', '{{__('Invalid Coupon Code.')}}', 'error');
            }
        }
        
        @if(!empty($paymentSetting['is_paystack_enabled']) && isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on')
        
        // Paystack Payment
        $(document).on("click", "#pay_with_paystack", function () {
            $('#paystack-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var coupon_id = res.coupon;

                    var paystack_callback = "{{ url('/plan/paystack') }}";
                    var order_id = '{{time()}}';
                    var handler = PaystackPop.setup({
                        key: '{{ $paymentSetting['paystack_public_key']  }}',
                        email: res.email,
                        amount: res.total_price * 100,
                        currency: res.currency,
                        ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                            1
                        ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                        metadata: {
                            custom_fields: [{
                                display_name: "Email",
                                variable_name: "email",
                                value: res.email,
                            }]
                        },

                        callback: function (response) {
                            console.log(response.reference, order_id);
                            window.location.href = paystack_callback + '/' + response.reference + '/' + '{{encrypt($plan->id)}}' + '?coupon_id=' + coupon_id + '&payment_frequency=' + res.payment_frequency
                        },
                        onClose: function () {
                            alert('window closed');
                        }
                    });
                    handler.openIframe();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        @endif

        @if(!empty($paymentSetting['is_flutterwave_enabled']) && isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on')
       
        // Flaterwave Payment
        $(document).on("click", "#pay_with_flaterwave", function () {
            $('#flaterwave-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var coupon_id = res.coupon;

                    var API_publicKey = '{{ $paymentSetting['flutterwave_public_key']  }}';
                    var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                    var flutter_callback = "{{ url('/plan/flaterwave') }}";
                    var x = getpaidSetup({
                        PBFPubKey: API_publicKey,
                        customer_email: '{{Auth::user()->email}}',
                        amount: res.total_price,
                        currency: res.currency,
                        txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' +
                            {{ date('Y-m-d') }},
                        meta: [{
                            metaname: "payment_id",
                            metavalue: "id"
                        }],
                        onclose: function () {
                        },
                        callback: function (response) {
                            var txref = response.tx.txRef;
                            if (
                                response.tx.chargeResponseCode == "00" ||
                                response.tx.chargeResponseCode == "0"
                            ) {
                                window.location.href = flutter_callback + '/' + txref + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id + '&payment_frequency=' + res.payment_frequency;
                            } else {
                                // redirect to a failure page.
                            }
                            x.close(); // use this to close the modal immediately after payment.
                        }
                    });
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        @endif
        
         @if(!empty($paymentSetting['is_razorpay_enabled']) && isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on')
        // Razorpay Payment
        $(document).on("click", "#pay_with_razorpay", function () {
            $('#razorpay-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var razorPay_callback = '{{url('/plan/razorpay')}}';
                    var totalAmount = res.total_price * 100;
                    var coupon_id = res.coupon;
                    var options = {
                        "key": "{{ $paymentSetting['razorpay_public_key']  }}", // your Razorpay Key Id
                        "amount": totalAmount,
                        "name": 'Plan',
                        "currency": res.currency,
                        "description": "",
                        "handler": function (response) {
                            window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id + '&payment_frequency=' + res.payment_frequency;
                        },
                        "theme": {
                            "color": "#528FF0"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        @endif
    </script>
@endpush
