@extends('layouts.admin')
@section('page-title')
    {{__('Settings')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="nav-tabs">
                <div class="col-lg-12 our-system">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#site-settings" class="active">{{__('Site Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#email-settings" class="">{{__('Email Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#payment-settings" class="">{{__('Payment Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#pusher-settings" class="">{{__('Pusher Setting')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="site-settings" class="tab-pane in active">
                        <div class="col-md-12">
                            {{Form::open(['route'=>'settings.store','method'=>'post', 'enctype' => 'multipart/form-data'])}}
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Site settings')}}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Favicon')}}</h4>
                                    <div class="card setting-card setting-logo-box">
                                        <div class="logo-content">
                                            <img src="{{asset(Storage::url('logo/favicon.png'))}}" class="small-logo" alt=""/>
                                        </div>
                                        <div class="choose-file mt-5">
                                            <label for="favicon">
                                                <div>{{__('Choose file here')}}</div>
                                                <input type="file" class="form-control" name="favicon" id="small-favicon" data-filename="edit-favicon">
                                            </label>
                                            <p class="edit-favicon"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Logo')}}</h4>
                                    <div class="card setting-card setting-logo-box">
                                        <div class="logo-content">
                                            <img src="{{asset(Storage::url('logo/logo-blue.png'))}}" class="big-logo" alt=""/>
                                        </div>
                                        <div class="choose-file mt-5">
                                            <label for="logo_blue">
                                                <div>{{__('Choose file here')}}</div>
                                                <input type="file" class="form-control" name="logo_blue" id="logo_blue" data-filename="edit-logo_blue">
                                            </label>
                                            <p class="edit-logo_blue"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Settings')}}</h4>
                                    <div class="card setting-card">
                                        <div class="form-group">
                                            {{Form::label('app_name',__('App Name'),array('class'=>'form-control-label')) }}
                                            {{Form::text('app_name',env('APP_NAME'),array('class'=>'form-control','placeholder'=>__('App Name')))}}
                                            @error('app_name')
                                            <span class="invalid-app_name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('footer_text',__('Footer Text'),array('class'=>'form-control-label')) }}
                                            {{Form::text('footer_text',env('FOOTER_TEXT'),array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                            @error('footer_text')
                                            <span class="invalid-footer_text" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('default_language',__('Default Language'),array('class'=>'form-control-label')) }}
                                            <div class="changeLanguage">
                                                <select name="default_language" id="default_language" class="form-control select2">
                                                    @foreach($workspace->languages() as $lang)
                                                        <option value="{{$lang}}" @if(env('DEFAULT_LANG') == $lang) selected @endif>
                                                            {{Str::upper($lang)}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="display_landing" id="display_landing" @if(env('DISPLAY_LANDING') == 'on') checked @endif>
                                                <label class="custom-control-label form-control-label" for="display_landing">{{ __('Landing Page Display') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="site_rtl" id="site_rtl" @if(env('SITE_RTL') == 'on') checked @endif>
                                                <label class="custom-control-label form-control-label" for="site_rtl">{{ __('RTL') }}</label>
                                            </div>
                                        </div>
                                               <div class="row">
                                    
                                         <div class="form-group col-md-6">
                                        {{Form::label('gdpr_cookie',__('GDPR Cookie')) }}
                                        
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gdpr_cookie" id="gdpr_cookie"{{ env('gdpr_cookie') == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="gdpr_cookie"></label>
                                            </div>
                                         </div>
                                   
                                        
                                         <div class="form-group col-md-6">
                                               @if(env('gdpr_cookie')=='on')
                                            {{Form::label('cookie_text',__('GDPR Cookie Text')) }}
                                             
                                            <input type="text" name="cookie_text" class="form-control" value="{{env('cookie_text')}}">
                                            @endif
                                         </div>
                                    
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-12 text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit">
                                </div>
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                    <div id="email-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Email settings')}}</h4>
                                </div>
                            </div>
                            <div class="card p-3">
                                {{Form::open(['route'=>'email.settings.store','method'=>'post'])}}
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_driver',__('Mail Driver'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                        @error('mail_driver')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_host',__('Mail Host'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))}}
                                        @error('mail_host')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_port',__('Mail Port'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                        @error('mail_port')
                                        <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_username',__('Mail Username'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                        @error('mail_username')
                                        <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_password',__('Mail Password'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                        @error('mail_password')
                                        <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_encryption',__('Mail Encryption'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                        @error('mail_encryption')
                                        <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_address',__('Mail From Address'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                        @error('mail_from_address')
                                        <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_name',__('Mail From Name'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                        @error('mail_from_name')
                                        <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-12 ">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <a href="#" data-url="{{route('test.email')}}" data-title="{{__('Send Test Mail')}}" class="btn btn-sm btn-info send_email">
                                                {{ __('Send Test Mail') }}
                                            </a>
                                        </div>
                                        <div class="form-group col-md-6 text-right">
                                            <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                        </div>
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="payment-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Payment settings')}}</h4>
                                </div>
                            </div>
                            <div class="card p-3">
                                {{Form::open(['route'=>'payment.settings.store','method'=>'post'])}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency_symbol',__('Currency Symbol *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','required','placeholder'=>__('Enter Currency Symbol')))}}
                                            @error('currency_symbol')
                                            <span class="invalid-currency_symbol" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency',__('Currency *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','required','placeholder'=>__('Enter Currency')))}}
                                            <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                            @error('currency')
                                            <span class="invalid-currency" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="payment-gateways" class="accordion accordion-spaced">
                                            <!-- Stripe -->
                                            <div class="card">
                                                <div class="card-header py-4" id="stripe-payment" data-toggle="collapse" role="button" data-target="#collapse-stripe" aria-expanded="false" aria-controls="collapse-stripe">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Stripe')}}</h6>
                                                </div>
                                                <div id="collapse-stripe" class="collapse" aria-labelledby="stripe-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Stripe')}}</h5>
                                                                <small>{{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_stripe_enabled" id="is_stripe_enabled" {{(isset($payment_detail['is_stripe_enabled']) && $payment_detail['is_stripe_enabled'] == 'on') ? 'checked' : ''}}>
                                                                    <label class="custom-control-label form-control-label" for="is_stripe_enabled">{{__('Enable Stripe')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('stripe_key', __('Stripe Key'),['class' => 'form-control-label']) }}
                                                                    {{ Form::text('stripe_key', (isset($payment_detail['stripe_key']) && !empty($payment_detail['stripe_key'])) ? $payment_detail['stripe_key']:'', ['class' => 'form-control','placeholder' => __('Stripe Key')]) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('stripe_secret', __('Stripe Secret'),['class' => 'form-control-label']) }}
                                                                    {{ Form::text('stripe_secret', (isset($payment_detail['stripe_secret']) && !empty($payment_detail['stripe_secret'])) ? $payment_detail['stripe_secret']:'', ['class' => 'form-control','placeholder' => __('Stripe Secret')]) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('stripe_webhook_secret', __('Stripe Webhook Secret'),['class' => 'form-control-label']) }}
                                                                    {{ Form::text('stripe_webhook_secret', (isset($payment_detail['stripe_webhook_secret']) && !empty($payment_detail['stripe_webhook_secret'])) ? $payment_detail['stripe_webhook_secret']:'', ['class' => 'form-control','placeholder' => __('Stripe Webhook Secret')]) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paypal -->
                                            <div class="card">
                                                <div class="card-header py-4" id="paypal-payment" data-toggle="collapse" role="button" data-target="#collapse-paypal" aria-expanded="false" aria-controls="collapse-paypal">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paypal')}}</h6>
                                                </div>
                                                <div id="collapse-paypal" class="collapse" aria-labelledby="paypal-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('PayPal')}}</h5>
                                                                <small>{{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_paypal_enabled" id="is_paypal_enabled" {{(isset($payment_detail['is_paypal_enabled']) && $payment_detail['is_paypal_enabled'] == 'on') ? 'checked' : ''}}>
                                                                    <label class="custom-control-label form-control-label" for="is_paypal_enabled">{{__('Enable Paypal')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-primary btn-sm {{ (!isset($payment_detail['paypal_mode']) || empty($payment_detail['paypal_mode']) || $payment_detail['paypal_mode'] == 'sandbox') ? 'active' : ''}}">
                                                                        <input type="radio" name="paypal_mode" value="sandbox" {{ (!isset($payment_detail['paypal_mode']) || empty($payment_detail['paypal_mode']) || $payment_detail['paypal_mode'] == 'sandbox') ? 'checked' : ''}}>{{ __('Sandbox') }}
                                                                    </label>
                                                                    <label class="btn btn-primary btn-sm {{ (isset($payment_detail['paypal_mode']) && $payment_detail['paypal_mode'] == 'live') ? 'active' : ''}}">
                                                                        <input type="radio" name="paypal_mode" value="live" {{ (isset($payment_detail['paypal_mode']) && $payment_detail['paypal_mode'] == 'live') ? 'checked' : ''}}>{{ __('Live') }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    {{ Form::label('paypal_client_id', __('Client ID'),['class' => 'form-control-label']) }}
                                                                    {{ Form::text('paypal_client_id', (isset($payment_detail['paypal_client_id'])) ? $payment_detail['paypal_client_id'] : '', ['class' => 'form-control','placeholder' => __('Client ID')]) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    {{ Form::label('paypal_secret_key', __('Secret Key'),['class' => 'form-control-label']) }}
                                                                    {{ Form::text('paypal_secret_key', isset($payment_detail['paypal_secret_key']) ? $payment_detail['paypal_secret_key'] : '', ['class' => 'form-control','placeholder' => __('Secret Key')]) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paystack -->
                                            <div class="card">
                                                <div class="card-header py-4" id="paystack-payment" data-toggle="collapse" role="button" data-target="#collapse-paystack" aria-expanded="false" aria-controls="collapse-paystack">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paystack')}}</h6>
                                                </div>
                                                <div id="collapse-paystack" class="collapse" aria-labelledby="paystack-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Paystack')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_paystack_enabled" id="is_paystack_enabled" {{ isset($payment_detail['is_paystack_enabled']) && $payment_detail['is_paystack_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_paystack_enabled">{{__('Enable Paystack')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paypal_client_id">{{ __('Public Key') }}</label>
                                                                    <input type="text" name="paystack_public_key" id="paystack_public_key" class="form-control" value="{{isset($payment_detail['paystack_public_key']) ? $payment_detail['paystack_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paystack_secret_key" id="paystack_secret_key" class="form-control" value="{{isset($payment_detail['paystack_secret_key']) ? $payment_detail['paystack_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FLUTTERWAVE -->
                                            <div class="card">
                                                <div class="card-header py-4" id="flutterwave-payment" data-toggle="collapse" role="button" data-target="#collapse-flutterwave" aria-expanded="false" aria-controls="collapse-flutterwave">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Flutterwave')}}</h6>
                                                </div>
                                                <div id="collapse-flutterwave" class="collapse" aria-labelledby="flutterwave-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Flutterwave')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_flutterwave_enabled" id="is_flutterwave_enabled" {{ isset($payment_detail['is_flutterwave_enabled'])  && $payment_detail['is_flutterwave_enabled']== 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_flutterwave_enabled">{{__('Enable Flutterwave')}}</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paypal_client_id">{{ __('Public Key') }}</label>
                                                                    <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" class="form-control" value="{{isset($payment_detail['flutterwave_public_key'])?$payment_detail['flutterwave_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key" class="form-control" value="{{isset($payment_detail['flutterwave_secret_key'])?$payment_detail['flutterwave_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Razorpay -->
                                            <div class="card">
                                                <div class="card-header py-4" id="razorpay-payment" data-toggle="collapse" role="button" data-target="#collapse-razorpay" aria-expanded="false" aria-controls="collapse-razorpay">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Razorpay')}}</h6>
                                                </div>
                                                <div id="collapse-razorpay" class="collapse" aria-labelledby="razorpay-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Razorpay')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_razorpay_enabled" id="is_razorpay_enabled" {{ isset($payment_detail['is_razorpay_enabled']) && $payment_detail['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_razorpay_enabled">{{__('Enable Razorpay')}}</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paypal_client_id">{{ __('Public Key') }}</label>
                                                                    <input type="text" name="razorpay_public_key" id="razorpay_public_key" class="form-control" value="{{ isset($payment_detail['razorpay_public_key'])?$payment_detail['razorpay_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paystack_secret_key">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="razorpay_secret_key" id="razorpay_secret_key" class="form-control" value="{{ isset($payment_detail['razorpay_secret_key'])?$payment_detail['razorpay_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mercado Pago-->
                                            <div class="card">
                                                <div class="card-header py-4" id="mercado_pago-payment" data-toggle="collapse" role="button" data-target="#collapse-mercado_pago" aria-expanded="false" aria-controls="collapse-mercado_pago">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mercado Pago')}}</h6>
                                                </div>
                                                <div id="collapse-mercado_pago" class="collapse" aria-labelledby="mercado_pago-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Mercado Pago')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_mercado_enabled" id="is_mercado_enabled" {{isset($payment_detail['is_mercado_enabled']) &&  $payment_detail['is_mercado_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_mercado_enabled">{{__('Enable Mercado Pago')}}</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mercado_app_id">{{ __('App ID') }}</label>
                                                                    <input type="text" name="mercado_app_id" id="mercado_app_id" class="form-control" value="{{isset($payment_detail['mercado_app_id']) ?  $payment_detail['mercado_app_id']:''}}" placeholder="{{ __('App ID') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mercado_secret_key">{{ __('App Secret KEY') }}</label>
                                                                    <input type="text" name="mercado_secret_key" id="mercado_secret_key" class="form-control" value="{{isset($payment_detail['mercado_secret_key']) ? $payment_detail['mercado_secret_key']:''}}" placeholder="{{ __('App Secret Key') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paytm -->
                                            <div class="card">
                                                <div class="card-header py-4" id="paytm-payment" data-toggle="collapse" role="button" data-target="#collapse-paytm" aria-expanded="false" aria-controls="collapse-paytm">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paytm')}}</h6>
                                                </div>
                                                <div id="collapse-paytm" class="collapse" aria-labelledby="paytm-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Paytm')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_paytm_enabled" id="is_paytm_enabled" {{ isset($payment_detail['is_paytm_enabled']) && $payment_detail['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_paytm_enabled">{{__('Enable Paytm')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 pb-4">
                                                                <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paytm Environment')}}</label> <br>
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-primary btn-sm {{isset($payment_detail['paytm_mode']) && $payment_detail['paytm_mode'] == 'local' ? 'active' : ''}}">
                                                                        <input type="radio" name="paytm_mode" value="local" {{ isset($payment_detail['paytm_mode']) && $payment_detail['paytm_mode'] == '' || isset($payment_detail['paytm_mode']) && $payment_detail['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>{{__('Local')}}
                                                                    </label>
                                                                    <label class="btn btn-primary btn-sm {{isset($payment_detail['paytm_mode']) && $payment_detail['paytm_mode'] == 'live' ? 'active' : ''}}">
                                                                        <input type="radio" name="paytm_mode" value="production" {{ isset($payment_detail['paytm_mode']) && $payment_detail['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>{{__('Production')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paytm_public_key">{{ __('Merchant ID') }}</label>
                                                                    <input type="text" name="paytm_merchant_id" id="paytm_merchant_id" class="form-control" value="{{isset($payment_detail['paytm_merchant_id'])? $payment_detail['paytm_merchant_id']:''}}" placeholder="{{ __('Merchant ID') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paytm_secret_key">{{ __('Merchant Key') }}</label>
                                                                    <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" class="form-control" value="{{ isset($payment_detail['paytm_merchant_key']) ? $payment_detail['paytm_merchant_key']:''}}" placeholder="{{ __('Merchant Key') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="paytm_industry_type">{{ __('Industry Type') }}</label>
                                                                    <input type="text" name="paytm_industry_type" id="paytm_industry_type" class="form-control" value="{{isset($payment_detail['paytm_industry_type']) ?$payment_detail['paytm_industry_type']:''}}" placeholder="{{ __('Industry Type') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mollie -->
                                            <div class="card">
                                                <div class="card-header py-4" id="mollie-payment" data-toggle="collapse" role="button" data-target="#collapse-mollie" aria-expanded="false" aria-controls="collapse-mollie">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mollie')}}</h6>
                                                </div>
                                                <div id="collapse-mollie" class="collapse" aria-labelledby="mollie-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Mollie')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_mollie_enabled" id="is_mollie_enabled" {{ isset($payment_detail['is_mollie_enabled']) && $payment_detail['is_mollie_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_mollie_enabled">{{__('Enable Mollie')}}</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mollie_api_key">{{ __('Mollie Api Key') }}</label>
                                                                    <input type="text" name="mollie_api_key" id="mollie_api_key" class="form-control" value="{{ isset($payment_detail['mollie_api_key'])?$payment_detail['mollie_api_key']:''}}" placeholder="{{ __('Mollie Api Key') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mollie_profile_id">{{ __('Mollie Profile Id') }}</label>
                                                                    <input type="text" name="mollie_profile_id" id="mollie_profile_id" class="form-control" value="{{ isset($payment_detail['mollie_profile_id'])?$payment_detail['mollie_profile_id']:''}}" placeholder="{{ __('Mollie Profile Id') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mollie_partner_id">{{ __('Mollie Partner Id') }}</label>
                                                                    <input type="text" name="mollie_partner_id" id="mollie_partner_id" class="form-control" value="{{ isset($payment_detail['mollie_partner_id'])?$payment_detail['mollie_partner_id']:''}}" placeholder="{{ __('Mollie Partner Id') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Skrill -->
                                            <div class="card">
                                                <div class="card-header py-4" id="skrill-payment" data-toggle="collapse" role="button" data-target="#collapse-skrill" aria-expanded="false" aria-controls="collapse-skrill">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Skrill')}}</h6>
                                                </div>
                                                <div id="collapse-skrill" class="collapse" aria-labelledby="skrill-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('Skrill')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_skrill_enabled" id="is_skrill_enabled" {{ isset($payment_detail['is_skrill_enabled']) && $payment_detail['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_skrill_enabled">{{__('Enable Skrill')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="mollie_api_key">{{ __('Skrill Email') }}</label>
                                                                    <input type="email" name="skrill_email" id="skrill_email" class="form-control" value="{{ isset($payment_detail['skrill_email'])?$payment_detail['skrill_email']:''}}" placeholder="{{ __('Skrill Email') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- CoinGate -->
                                            <div class="card">
                                                <div class="card-header py-4" id="coingate-payment" data-toggle="collapse" role="button" data-target="#collapse-coingate" aria-expanded="false" aria-controls="collapse-coingate">
                                                    <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('CoinGate')}}</h6>
                                                </div>
                                                <div id="collapse-coingate" class="collapse" aria-labelledby="coingate-payment" data-parent="#payment-gateways">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6 py-2">
                                                                <h5 class="h5">{{__('CoinGate')}}</h5>
                                                                <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                            </div>
                                                            <div class="col-6 py-2 text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="is_coingate_enabled" id="is_coingate_enabled" {{ isset($payment_detail['is_coingate_enabled']) && $payment_detail['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                    <label class="custom-control-label form-control-label" for="is_coingate_enabled">{{__('Enable CoinGate')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 pb-4">
                                                                <label class="coingate-label form-control-label" for="coingate_mode">{{__('CoinGate Mode')}}</label> <br>
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-primary btn-sm {{isset($payment_detail['coingate_mode']) && $payment_detail['coingate_mode'] == 'sandbox' ? 'active' : ''}}">
                                                                        <input type="radio" name="coingate_mode" value="sandbox" {{ isset($payment_detail['coingate_mode']) && $payment_detail['coingate_mode'] == '' || isset($payment_detail['coingate_mode']) && $payment_detail['coingate_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                                    </label>
                                                                    <label class="btn btn-primary btn-sm {{isset($payment_detail['coingate_mode']) && $payment_detail['coingate_mode'] == 'live' ? 'active' : ''}}">
                                                                        <input type="radio" name="coingate_mode" value="live" {{ isset($payment_detail['coingate_mode']) && $payment_detail['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label" for="coingate_auth_token">{{ __('CoinGate Auth Token') }}</label>
                                                                    <input type="text" name="coingate_auth_token" id="coingate_auth_token" class="form-control" value="{{ isset($payment_detail['coingate_auth_token'])?$payment_detail['coingate_auth_token']:''}}" placeholder="{{ __('CoinGate Auth Token') }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="pusher-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{ __('Pusher settings') }}</h4>
                                </div>
                            </div>
                            <div class="card p-3">
                                <form method="POST" action="{{ route('pusher.settings.store') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="enable_chat" id="enable_chat" value="yes" {{ env('CHAT_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="enable_chat">{{ __('Enable Chat') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_id" class="form-control-label">{{ __('Pusher App Id') }}</label>
                                            <input class="form-control" placeholder="Enter Pusher App Id" name="pusher_app_id" type="text" value="{{ env('PUSHER_APP_ID') }}" id="pusher_app_id">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_key" class="form-control-label">{{ __('Pusher App Key') }}</label>
                                            <input class="form-control " placeholder="Enter Pusher App Key" name="pusher_app_key" type="text" value="{{ env('PUSHER_APP_KEY') }}" id="pusher_app_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_secret" class="form-control-label">{{ __('Pusher App Secret') }}</label>
                                            <input class="form-control " placeholder="Enter Pusher App Secret" name="pusher_app_secret" type="text" value="{{ env('PUSHER_APP_SECRET') }}" id="pusher_app_secret">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_cluster" class="form-control-label">{{ __('Pusher App Cluster') }}</label>
                                            <input class="form-control " placeholder="Enter Pusher App Cluster" name="pusher_app_cluster" type="text" value="{{ env('PUSHER_APP_CLUSTER') }}" id="pusher_app_cluster">
                                        </div>
                                    </div>
                                    <div class="col-lg-12  text-right">
                                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit text-white">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).on("click", '.send_email', function (e) {
            e.preventDefault();
            var title = $(this).attr('data-title');

            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),
                }, function (data) {
                    $('#commonModal .modal-body .card-box').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function (e) {
            e.preventDefault();
            $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function () {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function (data) {
                    if (data.is_success) {
                        show_toastr('Success', data.message, 'success');
                    } else {
                        show_toastr('Error', data.message, 'error');
                    }
                    $("#email_sending").hide();
                },
                complete: function () {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        })
    </script>
@endpush
