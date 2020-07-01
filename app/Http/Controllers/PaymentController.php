<?php

namespace App\Http\Controllers;

use App\Payment;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function callback($status, $transac_id, $cust_ref, $pay_token)
    {
        Payment::create([
            'prescription_id' => 1,
            'status' => $status,
            'transac_id' => $transac_id,
            'cust_ref' => $cust_ref,
            'pay_token' => $pay_token
        ]);
    }


    public function pay(Request $request, Prescription $prescription)
    {
        $client = new GuzzleClient([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $patient = auth()->guard('api')->user();

        $order_id = rand(100,999999);
        $data = 
        [   
            "emailOrMobileNumber"=> "mudashiruagm@gmail.com",
            "merchantKey"=> "1572941388072",
            "amount"=> (float)$prescription->total_amount,
            "description"=> "Payment for drugs",
            "orderCode" => "$order_id",
            "sendInvoice"=> true,
            "payOption"=> "MTN_MONEY",
            "customerName"=> $patient->name,
            "customerMobileNumber"=> $patient->phone          
        
        ];

        $response = $client->post('https://app.slydepay.com.gh/api/merchant/invoice/create', [
            'json' => $data
        ]);
        $array = $response->getBody()->getContents();
        $json = json_decode($array, true);
        $collection = collect($json);
      
        if ($collection->get('success') == true) {

            $contents = $collection->get('result');
            $orderCode =  $contents['orderCode'];
            $paymentCode = $contents['paymentCode'];
            $payToken = $contents['payToken'];

            $payment =  Payment::create([
                'prescription_id' => $prescription->id,
                'orderCode' => $orderCode,
                'paymentCode' =>  $paymentCode,
                'pay_token' => $payToken
            ]);

            return response()->json([
                'status' => 'request sent'
            ]);
            
        } 
    }

}
