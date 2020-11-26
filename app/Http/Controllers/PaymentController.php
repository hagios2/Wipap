<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\PaymentRequest;
use App\Payment;
use App\Transaction;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback()
    {


    }


    public function getKey($seckey)
    {

        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);

        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

        $encryptionkey = $seckeyadjustedfirst12 . $hashedkeylast12;
        return $encryptionkey;

    }


    public function encrypt3Des($data, $key)
    {
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
    }


    public function payviacard(PaymentRequest $request)
    { // set up a function to test card payment.

        $cart = Cart::find($request->cart_id);

        $payment_amount = $this->calculatePayment($cart);
        $user = auth()->guard('api')->user();

        $email = $user->email;

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'cardno' => $request->cardno,
            'currency' => $request->currency,
            'country' => $request->country,
            'amount' => $payment_amount['grand_total'],
            "cvv" => $request->cvv,
            "expirymonth" => $request->expirymonth,
            "expiryyear" => $request->expiryyear,
            'email' => $email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phonenumber' => $request->phonenumber,
            'IP' => $_SERVER['REMOTE_ADDR'],
            'txRef' => 'MC-' . now(),
        );

        $request = $this->initiateCard($data);

        if ($request) {

            $result = json_decode($request, true);

            if ($result['status'] == 'success') {
                if (array_key_exists('suggested_auth', $result['data'])) {

                    if ($result['data']['suggested_auth'] == 'NOAUTH_INTERNATIONAL' || $result['data']['suggested_auth'] == 'AVS_VBVSECURECODE') {

                        $data['suggested_auth'] = "NOAUTH_INTERNATIONAL";
                        $data['billingzip'] = "07205";
                        $data["billingcity"] = "Hillside";
                        $data['billingaddress'] = "470 Mundet PI";
                        $data['billingstate'] = "BA";
                        $data['billingcountry'] = "US";

                        $result = json_decode($this->initiateCard($data), true);

                    } else if ($result['data']['suggested_auth'] == 'PIN') {
                        return response()->json(['status' => 'payment requires pin']);
                    }
                }

                Transaction::create([
                    'invoice_id' => $cart->invoice->invoice_id,
                    'user_id' => $user->id,
                    'transaction_status' => $request['data']['status'],
                    'grand_total_amount' => $payment_amount['grand_total'],
                    'total_amount_without_charges' => $payment_amount['total_rollover_cost_amount'],
                    'currency' => $data['currency'],
                    'txref' => $data['txRef']
                ]);

                $cart->update(['payment_status' => 'paid']);

                return response()->json(['

                    status' => 'success',

                    'authurl' => $result['data']['authurl'],

                    'chargeResponseMessage' => $result['data']['chargeResponseMessage'],

                    'redirect_url' => route('callback')
                ]);
            }

        } else {

            return response()->json(['status' => 'Payment failed']);
        }


    }

    public function encryptKeys($data)
    {
        $SecKey = env('RAVE_SECRET_KEY');

        $key = $this->getKey($SecKey);

        $dataReq = json_encode($data);

        $post_enc = $this->encrypt3Des($dataReq, $key);

        $postdata = array(
            'PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'client' => $post_enc,
            'alg' => '3DES-24');

        return $postdata;
    }

    public function initiateCard($data)
    {
        $postdata = $this->encryptKeys($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/charge");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);

        $headers = array('Content-Type: application/json');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        curl_close($ch);

        return $request;
    }

    public function payviamobilemoneygh(Request $request)
    { // set up a function to test card payment.

        $cart = Cart::find($request->cart_id);

        $payment_amount = $this->calculatePayment($cart);
        $user = auth()->guard('client')->user();

        if ($user->company) {
            $email = $user->company->company_email;
            $client['client_company_id'] = $user->company->id;

        } else {

            $email = $user->email;
            $client['client_id'] = $user->id;
        }

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'currency' => 'GHS',
            'country' => 'GH',
            'payment_type' => 'mobilemoneygh',
            'amount' => $payment_amount['grand_total'],
            'phonenumber' => $request->phonenumber,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'network' => $request->network ?? 'mtn',
            'email' => $email,
            'IP' => $_SERVER['REMOTE_ADDR'],
            'txRef' => 'MC-' . now(),
            'orderRef' => 'MXX-' . now(),
            'is_mobile_money_gh' => 1,

        );

        $request = $this->initiateCard($data);

        $result = json_decode($request, true);

        Transaction::create([
            'invoice_id' => $cart->invoice->invoice_id,
            key($client) => $client[key($client)],
            'transaction_status' => $request['data']['status'],
            'grand_total_amount' => $payment_amount['grand_total'],
            'total_amount_without_charges' => $payment_amount['total_rollover_cost_amount'],
            'currency' => $data['currency'],
            'txRef' => $data['txRef'],
            'orderRef' => $data['orderRef'],
            'isMomoPayment' => true
        ]);

        $cart->update(['payment_status' => 'paid']);

        return response()->json([

            'status' => 'success',

            'authurl' => $result['data']['link'],

            'payment_status' => $result['data']['status'],
            /*
              'redirect_url' => route('callback') */
        ]);

    }
}
