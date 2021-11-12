<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LivePixel\MercadoPago\MP;

class MercadoPaymentController extends Controller
{
    public $secret_key;
    public $app_id;
    public $is_enabled;
    public $currancy;

    public function setPaymentDetail()
    {
        $user = Auth::user();
        if($user->getGuard() == 'client')
        {
            $payment_setting = Utility::getPaymentSetting($user->currentWorkspace->id);
            $this->currancy  = (isset($user->currentWorkspace->currency_code)) ? $user->currentWorkspace->currency_code : 'USD';
        }
        else
        {
            $payment_setting = Utility::getAdminPaymentSetting();
            $this->currancy  = !empty(env('CURRENCY')) ? env('CURRENCY') : 'USD';
        }

        $this->secret_key = isset($payment_setting['mercado_secret_key']) ? $payment_setting['mercado_secret_key'] : '';
        $this->app_id     = isset($payment_setting['mercado_app_id']) ? $payment_setting['mercado_app_id'] : '';
        $this->is_enabled = isset($payment_setting['is_mercado_enabled']) ? $payment_setting['is_mercado_enabled'] : 'off';
    }

    public function planPayWithMercado(Request $request)
    {
        $this->setPaymentDetail();

        $authuser  = Auth::user();
        $planID    = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan      = Plan::find($planID);
        $coupon_id = '';

        if($plan)
        {
            /* Check for code usage */
            $plan->discounted_price = false;
            $price                  = $plan->{$request->mercado_payment_frequency . '_price'};

            if(isset($request->coupon) && !empty($request->coupon))
            {
                $request->coupon = trim($request->coupon);
                $coupons         = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if(!empty($coupons))
                {
                    $usedCoupun             = $coupons->used_coupon();
                    $discount_value         = ($price / 100) * $coupons->discount;
                    $plan->discounted_price = $price - $discount_value;

                    if($usedCoupun >= $coupons->limit)
                    {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }

                    $price     = $price - $discount_value;
                    $coupon_id = $coupons->id;
                }
                else
                {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            if($price <= 0)
            {
                $authuser->plan = $plan->id;
                $authuser->save();

                $assignPlan = $authuser->assignPlan($plan->id, $request->mercado_payment_frequency);

                if($assignPlan['is_success'] == true && !empty($plan))
                {
                    if(!empty($authuser->payment_subscription_id) && $authuser->payment_subscription_id != '')
                    {
                        try
                        {
                            $authuser->cancel_subscription($authuser->id);
                        }
                        catch(\Exception $exception)
                        {
                            \Log::debug($exception->getMessage());
                        }
                    }

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                    Order::create(
                        [
                            'order_id' => $orderID,
                            'name' => null,
                            'email' => null,
                            'card_number' => null,
                            'card_exp_month' => null,
                            'card_exp_year' => null,
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price == null ? 0 : $price,
                            'price_currency' => $this->currancy,
                            'txn_id' => '',
                            'payment_type' => __('Zero Price'),
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $res['msg']  = __("Plan successfully upgraded.");
                    $res['flag'] = 2;

                    return $res;
                }
                else
                {
                    return response()->json(
                        [
                            'message' => __('Plan fail to upgrade.'),
                        ], 401
                    );
                }
            }

            $preference_data = array(
                "items" => array(
                    array(
                        "title" => "Plan : " . $plan->name,
                        "quantity" => 1,
                        "currency_id" => $this->currancy,
                        "unit_price" => (float)$price,
                    ),
                ),
            );

            try
            {
                $mp         = new MP($this->app_id, $this->secret_key);
                $preference = $mp->create_preference($preference_data);

                return redirect($preference['response']['init_point']);
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }

    public function getPaymentStatus(Request $request)
    {
        $this->setPaymentDetail();

        Log::info(json_encode($request->all()));
    }

    public function invoicePayWithMercado(Request $request, $slug, $invoice_id)
    {
        $this->setPaymentDetail();

        $validatorArray = [
            'amount' => 'required',
        ];
        $validator      = Validator::make(
            $request->all(), $validatorArray
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', __($validator->errors()->first()));
        }

        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $invoice          = Invoice::find($request->invoice_id);

        if($invoice->getDueAmount() < $request->amount)
        {
            return redirect()->route(
                'client.invoices.show', [
                                          $currentWorkspace->slug,
                                          $invoice_id,
                                      ]
            )->with('error', __('Invalid amount.'));
        }

        $preference_data = array(
            "items" => array(
                array(
                    "title" => "Invoice : " . $request->invoice_id,
                    "quantity" => 1,
                    "currency_id" => $this->currancy,
                    "unit_price" => (float)$request->amount,
                ),
            ),
        );

        try
        {
            $mp         = new MP($this->app_id, $this->secret_key);
            $preference = $mp->create_preference($preference_data);

            return redirect($preference['response']['init_point']);
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getInvoicePaymentStatus($invoice_id, Request $request)
    {
        $this->setPaymentDetail();

        Log::info(json_encode($request->all()));
    }
}
