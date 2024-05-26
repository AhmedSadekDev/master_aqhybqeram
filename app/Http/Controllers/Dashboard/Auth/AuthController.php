<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\AuthRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function index() {
        return view('dashboard.pages.auth.login');
    }

    public function checkAuth(AuthRequest $request) {
        $remember_me = (request()->has('remember_me')) ? true : false;
        if(\Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember_me)) {
            if(\Auth::user()->user_type != User::TYPE_ADMIN) {
                \Auth::logout();
                return redirect()->route('login')->with('danger',__('لا يوجد لديك صلاحيه بالدخول هنا'))->withInput();
            }
            return redirect()->intended(route('dashboard.home'))->with('success', __("Welcome back."));
        } else {
            return redirect()->route('login')->with('danger',__('البريد الإلكتروني ام كلمه المرور غير صحيحه'))->withInput();
        }
    }

}
