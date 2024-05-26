<?php

namespace App\Http\Controllers\Dashboard\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Customers\CreateCustomersRequest;
use App\Http\Requests\Dashboard\Customers\UpdateCustomersRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class CustomersController extends Controller
{
    public function index() {

        $breadcrumb = [
            'title' =>  __("Customers lists"),
            'items' =>  [
                [
                    'title' =>  __("Customers Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = User::where('user_type',User::TYPE_CUSTOMER);
        if(request()->has('name') && request('name') != '' && !is_null(request('name'))) {
            $lists = $lists->where('email','like','%'.request('name').'%')->orWhere('first_name','like','%'.request('name').'%');
        }
        $lists = $lists->orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.customers.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'     =>$lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create New Customer"),
            'items' =>  [
                [
                    'title' =>  __("Customers Lists"),
                    'url'   => route('dashboard.customers.index'),
                ],
                [
                    'title' =>  __("Create New Customer"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.customers.create',[
            'breadcrumb'=>$breadcrumb
        ]);
    }

    public function store(CreateCustomersRequest $request) {
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);
        $data['email_verified_at'] = Carbon::now();
        $data['user_type'] = User::TYPE_CUSTOMER;
        $data = $this->uploadFiles($request , $data);
        $customer = User::create($data);
        return redirect()->route('dashboard.customers.index')->with('success', __("This row has been created."));
    }
    
    public function history(User $customer) {
        if($customer->id == \Auth::user()->id) {
            return redirect()->route('dashboard.profile.index');
        }
        if($customer->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.customers.index')->with('success', __("You Cant Access This Account."));
        }
        $breadcrumb = [
            'title' =>  __("بيانات الإشتراك"),
            'items' =>  [
                [
                    'title' =>  __("قائمه المستخدمن"),
                    'url'   => route('dashboard.customers.index'),
                ],
                [
                    'title' =>  __("بيانات الإشتراك"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('dashboard.pages.customers.show',[
            'breadcrumb'    =>  $breadcrumb,
            'customer'      =>  $customer,
            'lists'         =>  $customer->subscriptions()->where('payment_status',"done")->orderBy('id', 'desc')->paginate(),
        ]);
    }

    public function edit(User $customer) {
        if($customer->id == \Auth::user()->id) {
            return redirect()->route('dashboard.profile.index');
        }
        if($customer->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.customers.index')->with('success', __("You Cant Access This Account."));
        }
        $breadcrumb = [
            'title' =>  __("Edit Admin"),
            'items' =>  [
                [
                    'title' =>  __("قائمه المستخدمن"),
                    'url'   => route('dashboard.customers.index'),
                ],
                [
                    'title' =>  __("Edit Admin"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('dashboard.pages.customers.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'customer'      =>  $customer,
        ]);
    }

    public function update(UpdateCustomersRequest $request, User $customer) {
        if($customer->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.customers.index')->with('success', __("You Cant Access This Account."));
        }
        $data = $request->all();
        if(request()->has('password') && !is_null(request('password'))) {
            $data['password'] = Hash::make($request['password']);
        } else {
            unset($data['password']);
        }
        $data = $this->uploadFiles($request , $data);
        $customer->update($data);
        return redirect()->route('dashboard.customers.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,User $customer) {
        if($customer->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.customers.index')->with('success', __("You Cant Access This Account."));
        }
        $customer->delete();
        return redirect()->route('dashboard.customers.index')->with('success', __("This row has been deleted."));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('avatar') && !is_null(request('avatar'))) {
            $data['avatar'] = imageUpload($request['avatar'],'users');
        } else {
            if (isset($request['avatar'])){
                unset($request['avatar']);
            }
        }

        return $data;
    }
}
