<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Users\CreateUsersRequest;
use App\Http\Requests\Dashboard\Users\UpdateUsersRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {

        $breadcrumb = [
            'title' =>  __("Users lists"),
            'items' =>  [
                [
                    'title' =>  __("Users Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = User::where('user_type',User::TYPE_CUSTOMER);
        if(request()->has('name') && request('name') != '' && !is_null(request('name'))) {
            $lists = $lists->where('email','like','%'.request('name').'%')->orWhere('name','like','%'.request('name').'%');
        }
        $lists = $lists->orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.users.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'     =>$lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create New User"),
            'items' =>  [
                [
                    'title' =>  __("Users Lists"),
                    'url'   => route('dashboard.users.index'),
                ],
                [
                    'title' =>  __("Create New User"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.users.create',[
            'breadcrumb'=>$breadcrumb
        ]);
    }

    public function store(CreateUsersRequest $request) {
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);
        $data['email_verified_at'] = Carbon::now();
        $data['user_type'] = User::TYPE_CUSTOMER;
        $data = $this->uploadFiles($request , $data);
        User::create($data);
        return redirect()->route('dashboard.users.index')->with('success', __("This row has been created."));
    }
    
    public function edit(User $user) {
        if($user->id == \Auth::user()->id) {
            return redirect()->route('dashboard.profile.index');
        }
        if($user->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.users.index')->with('success', __("You Cant Access This Account."));
        }
        $breadcrumb = [
            'title' =>  __("Edit User"),
            'items' =>  [
                [
                    'title' =>  __("Users Lists"),
                    'url'   => route('dashboard.users.index'),
                ],
                [
                    'title' =>  __("Edit User"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('dashboard.pages.users.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'user'         =>  $user,
        ]);
    }

    public function update(UpdateUsersRequest $request, User $user) {
        if($user->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.users.index')->with('success', __("You Cant Access This Account."));
        }
        $data = $request->all();
        if(request()->has('password') && !is_null(request('password'))) {
            $data['password'] = Hash::make($request['password']);
        } else {
            unset($data['password']);
        }
        $data = $this->uploadFiles($request , $data);
        $user->update($data);
        return redirect()->route('dashboard.users.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,User $user) {
        if($user->user_type != User::TYPE_CUSTOMER) {
            return redirect()->route('dashboard.users.index')->with('success', __("You Cant Access This Account."));
        }
        $user->delete();
        return redirect()->route('dashboard.users.index')->with('success', __("This row has been deleted."));
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
