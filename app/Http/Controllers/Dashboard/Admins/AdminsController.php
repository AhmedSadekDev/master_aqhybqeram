<?php

namespace App\Http\Controllers\Dashboard\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admins\CreateAdminsRequest;
use App\Http\Requests\Dashboard\Admins\UpdateAdminsRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class AdminsController extends Controller
{
    public function index() {

        $breadcrumb = [
            'title' =>  __("Admins lists"),
            'items' =>  [
                [
                    'title' =>  __("Admins Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = User::where('user_type',User::TYPE_ADMIN);
        if(request()->has('name') && request('name') != '' && !is_null(request('name'))) {
            $lists = $lists->where('email','like','%'.request('name').'%')->orWhere('first_name','like','%'.request('name').'%');
        }
        $lists = $lists->orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.admins.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'     =>$lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create New Admin"),
            'items' =>  [
                [
                    'title' =>  __("Admins Lists"),
                    'url'   => route('dashboard.admins.index'),
                ],
                [
                    'title' =>  __("Create New Admin"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.admins.create',[
            'breadcrumb'=>$breadcrumb
        ]);
    }

    public function store(CreateAdminsRequest $request) {
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);
        $data['email_verified_at'] = Carbon::now();
        $data['user_type'] = User::TYPE_ADMIN;
        $data = $this->uploadFiles($request , $data);
        $admin = User::create($data);
        return redirect()->route('dashboard.admins.index')->with('success', __("This row has been created."));
    }
    
    public function edit(User $admin) {
        if($admin->id == \Auth::user()->id) {
            return redirect()->route('dashboard.profile.index');
        }
        if($admin->user_type != User::TYPE_ADMIN) {
            return redirect()->route('dashboard.admins.index')->with('success', __("You Cant Access This Account."));
        }
        $breadcrumb = [
            'title' =>  __("Edit Admin"),
            'items' =>  [
                [
                    'title' =>  __("Admins Lists"),
                    'url'   => route('dashboard.admins.index'),
                ],
                [
                    'title' =>  __("Edit Admin"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('dashboard.pages.admins.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'admin'         =>  $admin,
        ]);
    }

    public function update(UpdateAdminsRequest $request, User $admin) {
        if($admin->user_type != User::TYPE_ADMIN) {
            return redirect()->route('dashboard.admins.index')->with('success', __("You Cant Access This Account."));
        }
        $data = $request->all();
        if(request()->has('password') && !is_null(request('password'))) {
            $data['password'] = Hash::make($request['password']);
        } else {
            unset($data['password']);
        }
        $data = $this->uploadFiles($request , $data);
        $admin->update($data);
        return redirect()->route('dashboard.admins.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,User $admin) {
        if($admin->user_type != User::TYPE_ADMIN) {
            return redirect()->route('dashboard.admins.index')->with('success', __("You Cant Access This Account."));
        }
        $admin->delete();
        return redirect()->route('dashboard.admins.index')->with('success', __("This row has been deleted."));
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
