@extends('layouts.admin')

@section('page-title') {{ __('Plans') }} @endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="pricing-plan">
                    <ul class="nav nav-tabs">
                        <li>
                            <a data-toggle="tab" href="#monthly-biling" class="active">{{ __('Monthly Biling') }}</a>
                        </li>
                        <li class="annual-billing">
                            <a data-toggle="tab" href="#annual-billing">{{ __('Annual Billing') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <div id="monthly-biling" class="tab-pane in active">
                            <div class="row">
                                @foreach ($plans as $key => $plan)
                                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                                        <div class="plan-3">
                                            <h6>{{ $plan->name }}</h6>
                                            <p class="price">
                                                <sup>{{ (env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') }}</sup>
                                                {{ $plan->monthly_price }}
                                                <sub>{{ __('Per month') }}</sub>
                                            </p>
                                            <ul class="plan-detail">
                                                <li>{{ ($plan->trial_days < 0)?__('Unlimited'):$plan->trial_days }} {{__('Trial Days')}}</li>
                                                <li>{{ ($plan->max_workspaces < 0)?__('Unlimited'):$plan->max_workspaces }} {{__('Workspaces')}}</li>
                                                <li>{{ ($plan->max_users < 0)?__('Unlimited'):$plan->max_users }} {{__('Users Per Workspace')}}</li>
                                                <li>{{ ($plan->max_clients < 0)?__('Unlimited'):$plan->max_clients }} {{__('Clients Per Workspace')}}</li>
                                                <li>{{ ($plan->max_projects < 0)?__('Unlimited'):$plan->max_projects }} {{__('Projects Per Workspace')}}</li>
                                            </ul>
                                            <p class="price-text">
                                                {{ $plan->description }}
                                            </p>

                                            <div class="row">
                                                @if(Auth::user()->type != 'admin')
                                                    @if(\Auth::user()->plan == $plan->id && Auth::user()->is_trial_done == 1)
                                                        <p class="server-plan mb-3">
                                                            {{__('Trial Expires on ')}} <b>{{ (date('d M Y',strtotime(\Auth::user()->plan_expire_date))) }}</b>
                                                        </p>
                                                        @if((isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on') || (isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on') || (isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on') || (isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on') || (isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on') || (isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on') || (isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on') || (isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on') || (isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on') || (isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on'))
                                                            <div class="text-center">
                                                                <a href="{{route('payment',['monthly', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" id="interested_plan_{{ $plan->id }}" class="button btn btn-xs rounded-pill">
                                                                    <i class="fas fa-cart-plus mr-2"></i>{{ __('Subscribe') }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @elseif(\Auth::user()->plan == $plan->id && (empty(\Auth::user()->plan_expire_date) || date('Y-m-d') < \Auth::user()->plan_expire_date))
                                                        <p class="server-plan">
                                                            @if(!empty(\Auth::user()->plan_expire_date))
                                                                {{__('Plan Expires on ')}} <b>{{  date('d M Y',strtotime(\Auth::user()->plan_expire_date))}}</b>
                                                            @else
                                                                <b>{{__('Unlimited')}}</b>
                                                            @endif
                                                        </p>
                                                    @elseif((isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on') || (isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on') || (isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on') || (isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on') || (isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on') || (isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on') || (isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on') || (isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on') || (isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on') || (isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on'))
                                                        @if(\Auth::user()->is_trial_done == 0 && $plan->id != 1)
                                                            <div class="col">
                                                                <a href="{{route('take.a.plan.trial',$plan->id)}}" class="button btn btn-xs rounded-pill">
                                                                    <i class="fas fa-cart-plus mr-2"></i>{{ __('Active Free Trial') }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="col-auto">
                                                            <a href="{{route('payment',['monthly', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" id="interested_plan_{{ $plan->id }}" class="button btn btn-xs rounded-pill">
                                                                <i class="fas fa-cart-plus mr-2"></i>{{ __('Subscribe') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="annual-billing" class="tab-pane">
                            <div class="row">
                                @foreach ($plans as $key => $plan)
                                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                                        <div class="plan-3">
                                            <h6>{{ $plan->name }}</h6>
                                            <p class="price">
                                                <sup>{{ (env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$') }}</sup>
                                                {{ $plan->annual_price }}
                                                <sub>{{ __('Per Year') }}</sub>
                                            </p>
                                            <ul class="plan-detail">
                                                <li>{{ ($plan->trial_days < 0)?__('Unlimited'):$plan->trial_days }} {{__('Trial Days')}}</li>
                                                <li>{{ ($plan->max_workspaces < 0)?__('Unlimited'):$plan->max_workspaces }} {{__('Workspaces')}}</li>
                                                <li>{{ ($plan->max_users < 0)?__('Unlimited'):$plan->max_users }} {{__('Users Per Workspace')}}</li>
                                                <li>{{ ($plan->max_clients < 0)?__('Unlimited'):$plan->max_clients }} {{__('Clients Per Workspace')}}</li>
                                                <li>{{ ($plan->max_projects < 0)?__('Unlimited'):$plan->max_projects }} {{__('Projects Per Workspace')}}</li>
                                            </ul>
                                            <p class="price-text">
                                                {{ $plan->description }}
                                            </p>
                                            <div class="row">
                                                @if(Auth::user()->type != 'admin')
                                                    @if(\Auth::user()->plan == $plan->id && Auth::user()->is_trial_done == 1)
                                                        <p class="server-plan mb-3">
                                                            {{__('Trial Expires on ')}} <b>{{ (date('d M Y',strtotime(\Auth::user()->plan_expire_date))) }}</b>
                                                        </p>
                                                        @if((isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on') || (isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on') || (isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on') || (isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on') || (isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on') || (isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on') || (isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on') || (isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on') || (isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on') || (isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on'))
                                                            <div class="text-center">
                                                                <a href="{{route('payment',['annual', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" id="interested_plan_{{ $plan->id }}" class="button btn btn-xs rounded-pill">
                                                                    <i class="fas fa-cart-plus mr-2"></i>{{ __('Subscribe') }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @elseif(\Auth::user()->plan == $plan->id && (empty(\Auth::user()->plan_expire_date) || date('Y-m-d') < \Auth::user()->plan_expire_date))
                                                        <p class="server-plan">
                                                            @if(!empty(\Auth::user()->plan_expire_date))
                                                                {{__('Plan Expires on ')}} <b>{{  date('d M Y',strtotime(\Auth::user()->plan_expire_date))}}</b>
                                                            @else
                                                                <b>{{__('Unlimited')}}</b>
                                                            @endif
                                                        </p>
                                                    @elseif((isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on') || (isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on') || (isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on') || (isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on') || (isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on') || (isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on') || (isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on') || (isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on') || (isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on') || (isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on'))
                                                        @if(\Auth::user()->is_trial_done == 0 && $plan->id != 1)
                                                            <div class="col">
                                                                <a href="{{route('take.a.plan.trial',$plan->id)}}" class="button btn btn-xs rounded-pill">
                                                                    <i class="fas fa-cart-plus mr-2"></i>{{ __('Active Free Trial') }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="col-auto">
                                                            <a href="{{route('payment',['annual', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" id="interested_plan_{{ $plan->id }}" class="button btn btn-xs rounded-pill">
                                                                <i class="fas fa-cart-plus mr-2"></i>{{ __('Subscribe') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var tohref = '';
            @if(Auth::user()->is_register_trial == 1)
                tohref = $('#trial_{{ Auth::user()->interested_plan_id }}').attr("href");
            @elseif(Auth::user()->interested_plan_id != 0)
                tohref = $('#interested_plan_{{ Auth::user()->interested_plan_id }}').attr("href");
            @endif

            if (tohref != '') {
                window.location = tohref;
            }
        });
    </script>
@endpush
