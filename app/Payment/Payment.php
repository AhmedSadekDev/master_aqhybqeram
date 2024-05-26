<?php

namespace App\Payment;
use Illuminate\Support\Facades\Http as HttpRequest;
use App\Models\User\UserSubscription;

class Payment {


    //TEST
    // private $terminalId = "smartshope";// Will be provided by URWAY
    // private $password = "smartshopper@123";// Will be provided by URWAY
    // private $merchant_key = "519fd2855fe513ffb3b9a506fbccb48f6fbe62e476f0040cb87e48e0320c082c";
    // private $payment_url   = "https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest"; // test

    //Live
    private $terminalId    = "smartshope";
    private $password      = "smatrshope@URWAY_00";
    private $merchant_key  = "87ce2aaf015331ad412ccff048511bc87a173f0d69b28b0d77424570a059e248";
    private $payment_url   = "https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest"; //live

    private $currencyCode  = "SAR";

    private function resultUrl()
    {
        return url('/call-back');
    }

    private function get_server_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function payNow(UserSubscription $order)
    {
        if($order->payment_status != "in_process") {
            return [
                "status"        => 0,
                "message"       => "This Order Is Completed",
            ];
        }
        $orderID = 'ORDER-' . $order->id; //Customer Order ID
        $amount  = $order->subscription->price;
        $ip      = $this->get_server_ip();
        //Generate Hash
        $txn_details = $orderID . '|' . $this->terminalId . '|' . $this->password . '|' . $this->merchant_key . '|' . $amount . '|' . $this->currencyCode;
        $hash = hash('sha256', $txn_details);
        $fields = array(
            'trackid' => $orderID,
            'terminalId' => $this->terminalId,
            'customerEmail' => $order->user->email,
            'action' => "1",  // action is always 1
            'merchantIp' => "$ip",
            'password' => $this->password,
            'currency' => $this->currencyCode,
            'country' => "SA",
            'amount' => $amount,
            "udf1" => "Test1",
            "udf2" => $this->resultUrl(),//Response page URL
            "udf3" => "",
            "udf4" => "",
            "udf5" => "Test5",
            'requestHash' => $hash  //generated Hash
        );
        $response = HttpRequest::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ])->post($this->payment_url,$fields)->json();
        // dd($response);
        if($response['result'] == "UnSuccessful") {
            return [
                "status"        => 0,
                "url"           => null,
                "message"       => "Oops, something is failed",
            ];
        }
        if (!is_null($response['payid']) && !is_null($response['targetUrl'])) {
            $url = $response['targetUrl'] . '?paymentid=' . $response['payid'];
            return [
                "status"        => 1,
                "payment_id"    => $response['payid'],
                "url"           => $url,
            ];
        } else {
            return [
                "status"        => 0,
                "url"           => null,
                "message"       => "Oops, something is failed",
            ];
        }
    }

    public function result()
    {
        if ($_GET !== NULL) {
            $requestHash = "" . $_GET['TranId'] . "|" . $this->merchant_key . "|" . $_GET['ResponseCode'] . "|" . $_GET['amount'] . "";
            $txn_details1 = "" . $_GET['TrackId'] . "|" . $this->terminalId . "|" . $this->password . "|" . $this->merchant_key . "|" . $_GET['amount'] . "|SAR";


            $hash = hash('sha256', $requestHash);
            //	$hash1 = hash('sha256', $txn_details1);
            // echo $hash1; die;
            if ($hash === $_GET['responseHash']) {


                $txn_details1 = "" . $_GET['TrackId'] . "|" . $this->terminalId . "|" . $this->password . "|" . $this->merchant_key . "|" . $_GET['amount'] . "|SAR";
                //Secure check
                $requestHash1 = hash('sha256', $txn_details1);
                $fields = array(
                    'trackid' => $_GET['TrackId'],
                    'terminalId' => $this->terminalId,
                    'action' => '10',
                    'merchantIp' => "",
                    'password' => $this->password,
                    'currency' => "SAR",
                    'transid' => $_GET['TranId'],
                    'amount' => $_GET['amount'],
                    'udf5' => "",
                    'udf3' => "",
                    'udf4' => "",
                    'udf1' => "",
                    'udf2' => "",
                    'requestHash' => $requestHash1
                );

                // $url = "https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest"; // test
                $url = "https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest"; //live
                $response = HttpRequest::withHeaders([
                    'Content-Type'   => 'application/json',
                    'Accept'         => 'application/json',
                    'Content-Length' => strlen(json_encode($fields))
                ])->post($url,$fields)->json();



                $inquiryResponsecode    = $response['responseCode'];
                $inquirystatus          = $response['result'];


                if ($_GET['Result'] === 'Successful' && $_GET['ResponseCode'] === '000') {

                    if ($inquirystatus == 'Successful' || $inquiryResponsecode == '000') {
                        return response()->json([
                           'TrackId'=> $_GET['TrackId'],
                           'PaymentId'=> $_GET['PaymentId'],
                           'result'=> $_GET['Result'],
                           'ResponseCode'=> $_GET['ResponseCode'],
                           'AuthCode'=> $_GET['AuthCode'],
                           'cardBrand'=> $_GET['cardBrand'],
                           'amount'=> $_GET['amount'],
                        ]);

                    } else {
                        echo "Something went wrong!!! Secure Check failed!!!!!!!";
                    }

                } else {
                    return response()->json([
                        'result'=> $_GET['Result'],
                        'ResponseCode'=> $_GET['ResponseCode'],
                    ]);
                }
            } else {
                echo "Hash Mismatch!!!!!!!";

            }
        } else {

            echo "Something Went wrong!!!!!!!!!!!!";
        }
    }
}
