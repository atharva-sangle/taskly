@extends('layouts.admin')

@section('page-title') {{ __('Plans') }} @endsection

@section('action-button')
    @if(Auth::user()->type == 'admin')
        <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-size="md" data-title="{{ __('Add Plan') }}" data-url="{{route('plans.create')}}">
            <i class="fa fa-plus"></i> {{ __('Add Plan') }}
        </a>
    @endif
@endsection

@section('content')
    <section class="section">
        <div class="row">
            @foreach ($plans as $key => $plan)
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="plan-3">
                        <h6>
                            {{ $plan->name }}
                            @if((isset($paymentSetting['is_stripe_enabled']) && $paymentSetting['is_stripe_enabled'] == 'on') || (isset($paymentSetting['is_paypal_enabled']) && $paymentSetting['is_paypal_enabled'] == 'on') || (isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on') || (isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on') || (isset($paymentSetting['is_razorpay_enabled']) &&
                            $paymentSetting['is_razorpay_enabled'] == 'on') || (isset($paymentSetting['is_mercado_enabled']) && $paymentSetting['is_mercado_enabled'] == 'on') || (isset($paymentSetting['is_paytm_enabled']) && $paymentSetting['is_paytm_enabled'] == 'on') || (isset($paymentSetting['is_mollie_enabled']) && $paymentSetting['is_mollie_enabled'] == 'on') || (isset($paymentSetting['is_skrill_enabled']) && $paymentSetting['is_skrill_enabled'] == 'on') || (isset($paymentSetting['is_coingate_enabled']) && $paymentSetting['is_coingate_enabled'] == 'on'))
                                <a href="#" class="edit-icon d-flex align-items-center float-right" data-url="{{ route('plans.edit',$plan->id) }}" data-ajax-popup="true" data-title="{{__('Edit Plan')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endif
                        </h6>
                        @if($plan->id != 1)
                            <p class="price">
                                <small> <h6>{{(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$'}}{{$plan->monthly_price}} {{ __('Monthly Price') }}</h6> </small>
                            <small><h6>{{(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$'}}{{$plan->annual_price}} {{ __('Annual Price') }}</h6></small>
                            </p>
                        @endif
                        <ul class="plan-detail">
                            @if($plan->id != 1)
                                <li>{{ ($plan->trial_days < 0)?__('Unlimited'):$plan->trial_days }} {{__('Trial Days')}}</li>
                            @endif
                            <li>{{ ($plan->max_workspaces < 0)?__('Unlimited'):$plan->max_workspaces }} {{__('Workspaces')}}</li>
                            <li>{{ ($plan->max_users < 0)?__('Unlimited'):$plan->max_users }} {{__('Users Per Workspace')}}</li>
                            <li>{{ ($plan->max_clients < 0)?__('Unlimited'):$plan->max_clients }} {{__('Clients Per Workspace')}}</li>
                            <li>{{ ($plan->max_projects < 0)?__('Unlimited'):$plan->max_projects }} {{__('Projects Per Workspace')}}</li>
                        </ul>
                        <p class="price-text">
                            {{ $plan->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
