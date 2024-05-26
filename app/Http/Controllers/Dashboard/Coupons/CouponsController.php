<?php

namespace App\Http\Controllers\Dashboard\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Coupons\CreateCouponsRequest;
use App\Http\Requests\Dashboard\Coupons\UpdateCouponsRequest;
use App\Models\Coupon;
use App\Models\Store;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class CouponsController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Coupons lists"),
            'items' =>  [
                [
                    'title' =>  __("Coupons lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = new Coupon;
        if(request()->has('code') && request('code') != '' && !is_null(request('code'))) {
            $lists = $lists->orWhere('code','like','%'.request('code').'%');
        }
        if(request()->has('provider_id') && request('provider_id') != '0' && !is_null(request('provider_id'))) {
            $lists = $lists->orWhere('provider_id',request('provider_id'));
        }
        $lists = $lists->orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.coupons.index',[
            'breadcrumb'    => $breadcrumb,
            'lists'         => $lists,
            'stores'        => Store::all(),
        ]);
    }

    public function create() {
        $stores = Store::all();
        if(count($stores) == 0) {
            return redirect()->route('dashboard.coupons.index')->with('danger', __("Oops, Please Add Store First"));
        }
        $breadcrumb = [
            'title' =>  __("Create new Coupon"),
            'items' =>  [
                [
                    'title' =>  __("Coupons lists"),
                    'url'   => route('dashboard.coupons.index'),
                ],
                [
                    'title' =>  __("Create new Coupon"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.coupons.create',[
            'breadcrumb'    =>  $breadcrumb,
            'stores'        => $stores,
        ]);
    }

    public function store(CreateCouponsRequest $request) {
        $coupon = Coupon::create($request->all());

        $tokens     = User::where('user_type',User::TYPE_CUSTOMER)->pluck('dev_token')->toArray();
        $title      = "تم إضافه كوبون خصم جديد";
        $message    = __('Created New Coupon On :STORE Store',["STROE"=>$coupon->store->name]);

        Notification::create([
            'user_id'   => 0,
            'model_id'  => 0,
            'title'     => $title,
            'message'   => $message,
            'type'      => "coupon",
            'users'     => User::pluck('id')->toArray(),
        ]);


        PushFireBaseNotification($title,$message,"system","all",$tokens);

        return redirect()->route('dashboard.coupons.index')->with('success', __("This row has been created."));
    }

    public function edit(Coupon $coupon) {
        $breadcrumb = [
            'title' =>  __("Edit Coupon"),
            'items' =>  [
                [
                    'title' => __("Coupons lists"),
                    'url'   => route('dashboard.coupons.index'),
                ],
                [
                    'title' =>  __("Edit Coupon"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.coupons.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'coupon'        =>  $coupon,
            'stores'        => Store::all(),
        ]);
    }

    public function update(UpdateCouponsRequest $request, Coupon $coupon) {
        $coupon->update($request->all());
        return redirect()->route('dashboard.coupons.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,Coupon $coupon) {
        $coupon->delete();
        return redirect()->route('dashboard.coupons.index')->with('success', __("This row has been deleted."));
    }
}
