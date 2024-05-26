<?php

namespace App\Http\Controllers\API\Stores;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\API\Rate\RateRequest;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\User;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Rate;
// Resources
use App\Http\Resources\API\Store\StoreResource;
use App\Http\Resources\API\Coupon\CouponResource;
use App\Http\Resources\API\Rates\RatesResource;

class StoresController extends Controller
{
    public function index (Request $request) {
        $stores = Store::orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("Stores lists"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }

    public function show(Store $store) {
        $coupons = $store->coupons()->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("معلومات المتجر"))
            ->setData(new StoreResource($store))
            ->addAttribute('coupons',CouponResource::collection($coupons))
            ->addAttribute('pagination',api_model_set_paginate($coupons))
            ->build();
    }

    public function getStoreRates(Store $store) {
        $rates = $store->getRates()->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("التقيمات"))
            ->setData(RatesResource::collection($rates))
            ->addAttribute('count_rates',$store->rate)
            ->addAttribute('pagination',api_model_set_paginate($rates))
            ->build();
    }

    public function coupons(Store $store) {
        $coupons = $store->coupons()->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("Coupons Lists"))
            ->setData(CouponResource::collection($coupons))
            ->addAttribute('pagination',api_model_set_paginate($coupons))
            ->build();
    }

    public function showCoupon(Store $store,Coupon $coupon) {
        return (new API)
            ->isOk(__("معلومات الكوبون"))
            ->setData(new CouponResource($coupon))
            ->build();
    }

    public function rateStore(RateRequest $request,Store $store) {
        if(\Auth::user()->user_type != User::TYPE_CUSTOMER) {
            return (new API)->isOk(__('Oops, You Cant Access To This Area'))->build();
        }
        $rate = Rate::where([
            "user_id"    => \Auth::user()->id,
            "store_id"   => $store->id
        ])->first();
        if(!is_null($rate)) {
            return (new API)->isOk(__('عذرا تم التقيم من قبلكم من قبل'))->build();
        }
        Rate::create([
            'user_id'       => \Auth::user()->id,
            'store_id'      => $store->id,
            'message'       => $request->message,
            'rate'          => $request->rate,
        ]);
        // =============================== //
        $rateCount  = Rate::where('store_id',$store->id)->count();
        $rateSum    = Rate::where('store_id',$store->id)->sum('rate');
        $newRate    = $rateSum / $rateCount;
        $store->update([
            'rate'  => $newRate
        ]);
        return (new API)->isOk(__('شكرا علي التقيم'))->build();
    }

    public function storeOffer() {
        $stores = Store::where(['offer'=>1])->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("العروض"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }

    public function storeMoreChoice() {
        $stores = Store::where(['more_choice'=>1])->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("الاكثر اختيارا"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }

    public function storeRecommend() {
        $stores = Store::where(['recommend'=>1])->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("الموصي بها"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }

    public function storeUnmissableOffer() {
        $stores = Store::where(['unmissable_offer'=>1])->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("عرض لا يفوت"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }
}
