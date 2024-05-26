<?php

use Illuminate\Support\Facades\Route;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\User\UserSubscription;

Route::get('/', function(){
    return view('welcome');
});


Route::get('terms-conditions', function(){
    return view('terms');
});

Route::get('privacy-policy', function(){
    return view('privacy');
});

Route::get('/call-back', function(){
    $request = request()->all();
    $order = UserSubscription::where('payment_id',$request['PaymentId'])->first();
    if(is_null($order)) {
        // Order Not Found
        return (new API)->isError(__("هذا الطلب غير موجود لدينا"))->build();
    }
    if($order->payment_status != "in_process") {
        // Order Is Completed
        return (new API)->isError(__("هذا الطلب مستكمل من قبل"))->build();
    }
    if($request['Result'] == "Failure") {
        // Order Failure
        $order->update([
            'payment_status' => "failure",
            'active'         => 0,
        ]);
        return (new API)->isError(__("هذا الطلب منتهي"))->setData([
            'payment_id'    => $order->payment_id,
        ])->build();
    }
    // Order Done
    $order->update([
        'payment_status' => "done",
        'active'         => 1,
    ]);
    return (new API)->isOk(__("تم تفعيل الباقه"))->setData([
        'payment_id'    => $order->payment_id,
    ])->build();
});
