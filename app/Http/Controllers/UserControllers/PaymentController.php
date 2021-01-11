<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPaymentRequest;
use App\Http\Resources\UserPaymentTransactionResource;
use App\Services\PaymentService;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('callback');
    }

    public function callback(Request $request)
    {
        Log::info($request->all());

        $response= json_decode($request->response, true);

        $txref = $response['txRef'] ?? $response['data']['txRef'];

        $verified_payment = PaymentService::verifyPayment($txref);

        Log::info('logging Verified User Payment | '. $verified_payment);

        $payment = UserPayment::where('txRef',  $txref)->first();

        Log::info('logging User Payment response | '. $payment);

        if('successful' == $verified_payment){

            $payment->update(['status' => 'success']);

            $shop = User::find($payment->user_id);

            $shop->update(['payment_status' => 'paid']);

            Log::info('logging User Payment after update | '.  $shop);

        }else{
            $payment->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'callback received']);
    }

    public function payment(UserPaymentRequest $request)
    {
        $user = auth()->guard('api')->user();

        if ($request->payment_method === 'card_payment') {

            $billing_details = $user->addBillingDetail([
                'cardno' => $request->cardno,
                'expirymonth' => $request->expirymonth,
                'expiryyear' => $request->expiryyear,
                'cvv' => $request->cvv,
                'billingzip' => $request->billingzip,
                'billingcity' => $request->billingcity,
                'billingaddress' => $request->billingaddress,
                'billingstate' => $request->billingstate,
                'billingcountry' => $request->billingcountry ?? 'GH'
            ]);

            $payment_details = array_merge($billing_details->toArray(), [
                'amount' => 200,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'callback' => env('USER_PAYMENT_REDIRECT_URL')
            ]);

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {

                Log::error($payment_response);

                return response()->json(['message' => 'Payment process failed']);

            } else {

                Log::info($payment_response);

                UserPayment::create([
                    'merchandiser_id' => $user->id,
                    'billing_detail_id' => $billing_details->id,
                    'amount' => 200,
                    'email' => $request->email ?? $user->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phonenumber' => '233' . substr($request->phonenumber, -9),
                    'txRef' => $payment_response['txref'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                ]);

                $payment_response['callback_url'] = route('shop.payment.callback');

                return response()->json($payment_response);
            }

        } else { #momo

            $payment_details = [
                'amount' => 400,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'vendor' => $request->vendor,
                'callback' => env('SHOP_PAYMENT_REDIRECT_URL')
            ];

            if ($request->vendor === 'VODAFONE') {
                $payment_details['voucher'] = $request->voucher;
            }

            $payment_response = (new PaymentService)->payviamobilemoneygh($payment_details);

            if (gettype($payment_response) == 'string') {

                Log::error($payment_response);

                return response()->json(['message' => 'Payment process failed']);

            } else {

                Log::info($payment_response);

                UserPayment::create([
                    'merchandiser_id' => $user->id,
                    'amount' => 400,
                    'email' => $payment_details['email'],
                    'firstname' => $payment_details['firstname'],
                    'lastname' => $payment_details['lastname'],
                    'phonenumber' => '233' . substr($payment_details['phonenumber'], -9),
                    'txRef' => $payment_response['txRef'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                    'momo_payment' => true,
                    'vendor' => $payment_details['vendor']
                ]);

                $payment_response['callback_url'] = route('shop.payment.callback');

                return response()->json($payment_response);
            }
        }
    }

    public function paymentTransactions()
    {
        $transactions = UserPayment::where('user_id', auth()->guard('api')->id())->get();

        return UserPaymentTransactionResource::collection($transactions);
    }
}
