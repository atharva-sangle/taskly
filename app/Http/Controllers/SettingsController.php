<?php

namespace App\Http\Controllers;

use App\Models\Mail\EmailTest;
use App\Models\Utility;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->type == 'admin')
        {
            $workspace      = new Workspace();
            $payment_detail = Utility::getAdminPaymentSetting();

            return view('setting', compact('workspace', 'payment_detail'));
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function store(Request $request)
    {   
    
        $user = Auth::user();
        if($user->type == 'admin')
        {
            if($request->favicon)
            {
                $request->validate(['favicon' => 'required|image|mimes:png|max:204800']);
                $request->favicon->storeAs('logo', 'favicon.png');
            }
            if($request->logo_blue)
            {
                $request->validate(['logo_blue' => 'required|image|mimes:png|max:204800']);
                $request->logo_blue->storeAs('logo', 'logo-blue.png');
            }
            if($request->logo_white)
            {
                $request->validate(['logo_white' => 'required|image|mimes:png|max:204800']);
                $request->logo_white->storeAs('logo', 'logo-white.png');
            }

            $rules = [
                'app_name' => 'required|string|max:50',
                'default_language' => 'required|string|max:50',
                'footer_text' => 'required|string|max:50',
            ];

            $request->validate($rules);
             $cookie_text =   (!isset($request->cookie_text) && empty($request->cookie_text)) ? '' : $request->cookie_text;
            $arrEnv = [

               
                'APP_NAME' => $request->app_name,
                'DEFAULT_LANG' => $request->default_language,
                'FOOTER_TEXT' => $request->footer_text,
                'DISPLAY_LANDING' => $request->display_landing ?? 'on',
                'SITE_RTL' => $request->site_rtl ?? 'off',
                'gdpr_cookie' => !isset($request->gdpr_cookie) ? 'off' : 'on',
                'cookie_text'=>  $cookie_text,

            ];

            if($this->setEnvironmentValue($arrEnv))
            {
                return redirect()->back()->with('success', __('Setting updated successfully'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function emailSettingStore(Request $request)
    {
        $user = Auth::user();
        if($user->type == 'admin')
        {
            $rules = [
                'mail_driver' => 'required|string|max:50',
                'mail_host' => 'required|string|max:50',
                'mail_port' => 'required|string|max:50',
                'mail_username' => 'required|string|max:50',
                'mail_password' => 'required|string|max:255',
                'mail_encryption' => 'required|string|max:50',
                'mail_from_address' => 'required|string|max:50',
                'mail_from_name' => 'required|string|max:50',
            ];

            $request->validate($rules);

            $arrEnv = [
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ];

            if($this->setEnvironmentValue($arrEnv))
            {
                return redirect()->back()->with('success', __('Setting updated successfully'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function paymentSettingStore(Request $request)
    {
        $user = Auth::user();
        if($user->type == 'admin')
        {
            $validate = [
                'currency' => 'required|string|max:50',
                'currency_symbol' => 'required|string|max:50',
            ];

            if(isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on')
            {
                $validate['stripe_key']    = 'required|string';
                $validate['stripe_secret'] = 'required|string';
            }
            if(isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on')
            {
                $validate['paypal_client_id']  = 'required|string';
                $validate['paypal_secret_key'] = 'required|string';
            }
            if(isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on')
            {
                $validate['paystack_public_key'] = 'required|string';
                $validate['paystack_secret_key'] = 'required|string';
            }
            if(isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on')
            {
                $validate['flutterwave_public_key'] = 'required|string';
                $validate['flutterwave_secret_key'] = 'required|string';
            }
            if(isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on')
            {
                $validate['razorpay_public_key'] = 'required|string';
                $validate['razorpay_secret_key'] = 'required|string';
            }
            if(isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on')
            {
                $validate['mercado_app_id']     = 'required|string';
                $validate['mercado_secret_key'] = 'required|string';
            }
            if(isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on')
            {
                $validate['paytm_mode']          = 'required|string';
                $validate['paytm_merchant_id']   = 'required|string';
                $validate['paytm_merchant_key']  = 'required|string';
                $validate['paytm_industry_type'] = 'required|string';
            }
            if(isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on')
            {
                $validate['mollie_api_key']    = 'required|string';
                $validate['mollie_profile_id'] = 'required|string';
                $validate['mollie_partner_id'] = 'required|string';
            }
            if(isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on')
            {
                $validate['skrill_email'] = 'required|email';
            }
            if(isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on')
            {
                $validate['coingate_mode']       = 'required|string';
                $validate['coingate_auth_token'] = 'required|string';
            }

            $validator = Validator::make(
                $request->all(), $validate
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $arrEnv = [
                'CURRENCY_SYMBOL' => $request->currency_symbol,
                'CURRENCY' => $request->currency,
            ];

            $this->setEnvironmentValue($arrEnv);

            if(isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on')
            {
                $post['is_stripe_enabled']     = $request->is_stripe_enabled;
                $post['stripe_key']            = $request->stripe_key;
                $post['stripe_secret']         = $request->stripe_secret;
                $post['stripe_webhook_secret'] = $request->stripe_webhook_secret;
            }
            else
            {
                $post['is_stripe_enabled'] = 'off';
            }

            // Save Paypal Detail
            if(isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on')
            {
                $post['is_paypal_enabled'] = $request->is_paypal_enabled;
                $post['paypal_mode']       = $request->paypal_mode;
                $post['paypal_client_id']  = $request->paypal_client_id;
                $post['paypal_secret_key'] = $request->paypal_secret_key;
            }
            else
            {
                $post['is_paypal_enabled'] = 'off';
            }

            // Save Paystack Detail
            if(isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on')
            {
                $post['is_paystack_enabled'] = $request->is_paystack_enabled;
                $post['paystack_public_key'] = $request->paystack_public_key;
                $post['paystack_secret_key'] = $request->paystack_secret_key;
            }
            else
            {
                $post['is_paystack_enabled'] = 'off';
            }

            // Save Fluuterwave Detail
            if(isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on')
            {
                $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
                $post['flutterwave_public_key'] = $request->flutterwave_public_key;
                $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
            }
            else
            {
                $post['is_flutterwave_enabled'] = 'off';
            }

            // Save Razorpay Detail
            if(isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on')
            {
                $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
                $post['razorpay_public_key'] = $request->razorpay_public_key;
                $post['razorpay_secret_key'] = $request->razorpay_secret_key;
            }
            else
            {
                $post['is_razorpay_enabled'] = 'off';
            }

            // Save Marcado Detail
            if(isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on')
            {
                $post['is_mercado_enabled'] = $request->is_mercado_enabled;
                $post['mercado_app_id']     = $request->mercado_app_id;
                $post['mercado_secret_key'] = $request->mercado_secret_key;
            }
            else
            {
                $post['is_mercado_enabled'] = 'off';
            }

            // Save Paytm Detail
            if(isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on')
            {
                $post['is_paytm_enabled']    = $request->is_paytm_enabled;
                $post['paytm_mode']          = $request->paytm_mode;
                $post['paytm_merchant_id']   = $request->paytm_merchant_id;
                $post['paytm_merchant_key']  = $request->paytm_merchant_key;
                $post['paytm_industry_type'] = $request->paytm_industry_type;
            }
            else
            {
                $post['is_paytm_enabled'] = 'off';
            }

            // Save Mollie Detail
            if(isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on')
            {
                $post['is_mollie_enabled'] = $request->is_mollie_enabled;
                $post['mollie_api_key']    = $request->mollie_api_key;
                $post['mollie_profile_id'] = $request->mollie_profile_id;
                $post['mollie_partner_id'] = $request->mollie_partner_id;
            }
            else
            {
                $post['is_mollie_enabled'] = 'off';
            }

            // Save Skrill Detail
            if(isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on')
            {
                $post['is_skrill_enabled'] = $request->is_skrill_enabled;
                $post['skrill_email']      = $request->skrill_email;
            }
            else
            {
                $post['is_skrill_enabled'] = 'off';
            }

            // Save Coingate Detail
            if(isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on')
            {
                $post['is_coingate_enabled'] = $request->is_coingate_enabled;
                $post['coingate_mode']       = $request->coingate_mode;
                $post['coingate_auth_token'] = $request->coingate_auth_token;
            }
            else
            {
                $post['is_coingate_enabled'] = 'off';
            }

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                \DB::insert('insert into admin_payment_settings (`value`, `name`,`created_at`,`updated_at`) values (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`)', [
                    $data,
                    $key,
                    $created_at,
                    $updated_at,
                ]);
            }

            return redirect()->back()->with('success', __('Payment Setting updated successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function pusherSettingStore(Request $request)
    {
        $user = Auth::user();
        if($user->type == 'admin')
        {
            $rules = [];

            if($request->enable_chat == 'yes')
            {
                $rules['pusher_app_id']      = 'required|string|max:50';
                $rules['pusher_app_key']     = 'required|string|max:50';
                $rules['pusher_app_secret']  = 'required|string|max:50';
                $rules['pusher_app_cluster'] = 'required|string|max:50';
            }

            $request->validate($rules);

            $arrEnv = [
                'CHAT_MODULE' => $request->enable_chat,
                'PUSHER_APP_ID' => $request->pusher_app_id,
                'PUSHER_APP_KEY' => $request->pusher_app_key,
                'PUSHER_APP_SECRET' => $request->pusher_app_secret,
                'PUSHER_APP_CLUSTER' => $request->pusher_app_cluster,
            ];

            if($this->setEnvironmentValue($arrEnv))
            {
                return redirect()->back()->with('success', __('Setting updated successfully'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if(count($values) > 0)
        {
            foreach($values as $envKey => $envValue)
            {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if(!$keyPosition || !$endOfLinePosition || !$oldLine)
                {
                    $str .= "{$envKey}='{$envValue}'\n";
                }
                else
                {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";

        return file_put_contents($envFile, $str) ? true : false;
    }

    public function testEmail(Request $request)
    {
        $user = Auth::user();

        if($user->type == 'admin')
        {
            $data                      = [];
            $data['mail_driver']       = $request->mail_driver;
            $data['mail_host']         = $request->mail_host;
            $data['mail_port']         = $request->mail_port;
            $data['mail_username']     = $request->mail_username;
            $data['mail_password']     = $request->mail_password;
            $data['mail_encryption']   = $request->mail_encryption;
            $data['mail_from_address'] = $request->mail_from_address;
            $data['mail_from_name']    = $request->mail_from_name;

            return view('users.test_email', compact('data'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function testEmailSend(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        try
        {
            config([
                       'mail.driver' => $request->mail_driver,
                       'mail.host' => $request->mail_host,
                       'mail.port' => $request->mail_port,
                       'mail.encryption' => $request->mail_encryption,
                       'mail.username' => $request->mail_username,
                       'mail.password' => $request->mail_password,
                       'mail.from.address' => $request->mail_from_address,
                       'mail.from.name' => $request->mail_from_name,
                   ]);
            Mail::to($request->email)->send(new EmailTest());
        }
        catch(\Exception $e)
        {
            return response()->json([
                                        'is_success' => false,
                                        'message' => $e->getMessage(),
                                    ]);
        }

        return response()->json([
                                    'is_success' => true,
                                    'message' => __('Email send Successfully'),
                                ]);
    }

}
