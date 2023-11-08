<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setup\Site;
use App\Models\Setup\SiteOffence;
use App\Models\Setup\Area;
use App\Models\UserPayment;
use App\Models\casemanagement\enviro\Enviro;
use App\Models\casemanagement\enviro\master\ManualRepresentationReason;
use App\Notifications\PaymentConfirmation;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Log;

class PaymentsController extends Controller
{
    public function fetch_site_info($slug)
    {
        $site = Site::where('slug', $slug)->first();
        if(!$site) {
            return response()->json([
                'success' => false,
                'message' => "not_found"
            ]);
        }

        $reason = ManualRepresentationReason::where('isOnline', '1')->get();
        return response()->json([
            'success' => true,
            'reason' => $reason,
            'data' => $site,
        ]);
    }

    public function search_fpn(Request $request)
    {
        if(!isset($request->fpn))
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number"
            ]);
        }

        $fpn = $request->fpn;

        $row = Enviro::where('fpn_number', $fpn)->first();
        if(!$row)
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number"
            ]);
        }

        if($row->is_paid == 1)
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number "
            ]);
        }
        

        return response()->json([
            'success' => true,
            'data' => $row
        ]);
    }

    public function search_enviro(Request $request)
    {
        if(!isset($request->fpn_number))
        {
            return response()->json([
                'success' => false,
                'message' => "not_found"
            ]);
        }

        $row = Enviro::with('site')->with('zone')->with('offence')->with('offender')->where('fpn_number', $request->fpn_number)->first();

        if(!$row)
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number"
            ]);
        }

        $area_id = $row->town_area;

        $site_offence = SiteOffence::where('offence_id', $row->offence_type_id)->where('site_id', $row->site_id)->first();

        if($site_offence)
        {
            $issue_datetime = $row->issue_datetime;

            $currentDateTime = Carbon::now();
            $targetDateTime = Carbon::parse($issue_datetime);

            $diffInDays = $currentDateTime->diffInDays($targetDateTime);
            
            $charge_reduced_days = (int)$site_offence->charge_days_reduced;
            $charge_full_days = (int)$site_offence->charge_days_full;
            
            if($diffInDays <= $charge_reduced_days)
            {
                $amount = $site_offence->charge_amount_reduced;
            }
            else
            {
                $amount = $site_offence->charge_amount_full;
            }

            $row->amount = $amount;
            
        }else{
            $row->amount = 0;
        }

        $area = Area::find($area_id);
        if($area)
        {
            $row->area = $area->name;
        }else{
            $row->area = null;
        }

        return response()->json([
            'success' => true,
            'data' => $row 
        ]);
        
    }

    public function create_payment(Request $request)
    {
        try {

            $data = UserPayment::create([
                'fpn_number' => $request->fpn_number,
                'site_id' => $request->site_id,
                'enviro_id' => $request->enviro_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'country' => $request->country,
                'post_code' => $request->post_code,
                'phone' => $request->phone_number,
                'amount' => $request->amount
            ]);
            

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => $th
            ]);

        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Unpaid invoice generated'
        ]);
    }

    public function pay(Request $request)
    {
        if(!isset($request->identifier))
        {
            return response()->json([
                'success'=> false,
                'message'=> 'Invalid card identifier' 
            ]);
        }

        $identifier = $request->identifier;
        $session_key = $request->session_key;
        $payment_id = $request->payment_id;

        $user_payment = UserPayment::find($payment_id);
        if(!$user_payment)
        {
            return response()->json([
                'succes' => false,
                'message' => "Invalid payment attempt"
            ]);
        }

        $amount = (int)$user_payment->amount;

        $payload = [
            "transactionType" => 'Payment',
            "paymentMethod" => [
                "card" => [
                    'merchantSessionKey' => $session_key,
                    'cardIdentifier' => $identifier
                ]
            ],
            "vendorTxCode" => "TR".$user_payment->id.rand(99,999),
            "amount" => $amount,
            "currency" => "GBP",
            "description" => "transaction",
            "customerFirstName" => $user_payment->first_name,
            "customerLastName" => $user_payment->last_name,
            "billingAddress" => [
                "address1" => $user_payment->address_line1,
                "city" => $user_payment->city,
                "postalCode" => $user_payment->post_code,
                "country" => $user_payment->country
            ]
        ];

        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => env('OPAYO_BASE_URL','https://pi-test.sagepay.com/api/v1').'/transactions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($payload),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode(env('OPAYO_INTEGRATION_KEY','hJYxsw7HLbj40cB8udES8CDRFLhuJ8G54O6rDpUXvE6hYDrria').':'.env('OPAYO_INTEGRATION_PASSWORD','o2iHSrFybYMZpmWOQMuhsXP52V4fBtpuSDshrKDSWsBY1OiN6hwd9Kb12z4j5Us5u')),
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $transaction = json_decode($response, true);

        if($transaction['statusCode'] == 0000)
        {
            $transaction_id = $transaction['transactionId'];

            $payment_datetime = Carbon::now()->toDatetimeString();

            UserPayment::where('id', $payment_id)->update([
                'transaction_id' => $transaction_id,
                'status' => 1
            ]);

            Enviro::where('id',$user_payment->enviro_id)->update([
                'is_paid' => 1,
                'fpn_status' => 'paid',
                'payment_datetime' => $payment_datetime
            ]);

            $mailData = [
                'first_name' => $user_payment->first_name,
                'fpn_number' => $user_payment->fpn_number,
                'transaction_id' => $transaction_id,
                'amount' => $user_payment->amount
            ];

            // Send Confirmation Email to User
            try {
                Notification::route('mail', $user_payment->email)
                    ->notify(new PaymentConfirmation($mailData));
            } catch (\Throwable $th) {
                Log::info('Mail Error!');
                Log::info($th);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment Successful'
            ]);
        }
        else{
            $error = $transaction['statusDetail'];

            return response()->json([
                'success' => false,
                'message' => $error
            ]);
        }


    }   
}