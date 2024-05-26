<?php

namespace App\Http\Controllers\API\Subscriptions;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\API\Subscriptions\SubscriptionsRequest;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Subscription;
use App\Models\User\UserSubscription;
// Resources
use App\Http\Resources\API\Subscriptions\SubscriptionsResource;
// Payment
use App\Payment\Payment;

class SubscriptionsController extends Controller
{
    public function index (Request $request) {
        $subscriptions = Subscription::all();
        return (new API)
            ->isOk(__("Subscriptions lists"))
            ->setData(SubscriptionsResource::collection($subscriptions))
            ->build();
    }

    public function store(SubscriptionsRequest $request) {
        $subscription = Subscription::find($request->subscription_id);
        if(is_null($subscription)) {
            return (new API)->isError(__("هذا الإشتراك غير موجود لدينا"))->build();
        }
        $user = \Auth::user();
        if(is_null($user->subscriptions)) {
            $user->subscriptions()->create([
                'subscription_id'   => $subscription->id,
                'start'             => \Carbon\Carbon::now(),
                'end'               => \Carbon\Carbon::now()->addMonth($subscription->month),
            ]);
            return (new API)->isOk(__("شكرا لك علي الإشتراك"))->build();
        }
        $ss = $user->subscriptions()->where('active',1)->first();
        if(!is_null($ss)) {
            return (new API)->isOk(__("عذرا لديك بالفعل اشتراك فعال"))->build();
        }
        $order = $user->subscriptions()->create([
            'subscription_id'   => $subscription->id,
            'price'             => $subscription->price,
            'start'             => \Carbon\Carbon::now(),
            'end'               => \Carbon\Carbon::now()->addMonth($subscription->month),
            'active'            => 0,
        ]);
        $order = UserSubscription::find($order->id);
        $payment    = (new Payment)->payNow($order);
        if($payment['status'] == 1) {
            $order->update([
                'payment_id'    => $payment['payment_id']
            ]);
            return (new API)->isOk(__("شكرا لك علي اختيار الباقة برجاء سداد قيمتها الان"))->setData([
                "paymentUrl"    => $payment['url']
            ])->build();
        } else {
            return (new API)->isError(__($payment['message']))->build();
        }
    }
}
