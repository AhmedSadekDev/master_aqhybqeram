<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\CheckPhoneRequest;
use App\Http\Requests\API\Auth\VerifiedPhoneRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ForgetPasswordRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
// Models
use App\Models\User;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\User\UserResource;

class AuthController extends Controller
{

    public function login(LoginRequest $request) {
        $authOnce = \Auth::once([
            'phone'    => $request->phone,
            'password' => $request->password,
        ]);
        $user = false;
        if ($authOnce) {
            $user = User::find(\Auth::getUser()->id);
        }
        if (!$user) {
            return (new API)->isError(__("Phone Or Password Is Failed"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        $user->update([
            'api_token'        => generate_api_token(),
            'dev_token'        => $request->devices_token,
        ]);

        if(is_null($user->phone_verified_at)) {
            return (new API)->isError(__('Please verified Phone'))->addAttribute('action','phone_verified')->addAttribute('api_token',$user->api_token)->build();
        }
        if(is_null($user->completed_data)) {
            return (new API)->isError(__('Please Completed Account'))->addAttribute('action','completed_data')->addAttribute('api_token',$user->api_token)->build();
        }
        return (new API)->setStatusOk()
            ->setMessage(__("User information"))
            ->setData(new UserResource($user))
            ->addAttribute('api_token',$user->api_token)
            ->build();
    }

    public function checkPhone(CheckPhoneRequest $request) {
        $user = User::where(['phone'=>$request->phone])->first();
        // $activated_code = rand(1000,9999);
        if (!is_null($user)) {
            if($user->user_type == User::TYPE_ADMIN) {
                return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
            }
            // if(is_null($user->phone_verified_at)) {
            //     $user->update([
            //         'activated_code'    => $activated_code,
            //         'api_token'         => generate_api_token(),
            //     ]);
            // } else {
            // }
            return (new API)->isError(__('This Phone Used Before'))->build();
        } else {
            // $user = User::create([
            //     'first_name'        => "New Account ".User::TYPE_CUSTOMER,
            //     'last_name'         => "New Account ".User::TYPE_CUSTOMER,
            //     'phone'             => $request->phone,
            //     'email'             => $request->phone."@test.com",
            //     'password'          => \Hash::make("teeest"),
            //     'activated_code'    => $activated_code,
            //     'api_token'         => generate_api_token(),
            //     'user_type'         => User::TYPE_CUSTOMER
            // ]);
        }
        // Send SMS
        return (new API)->setStatusOk()
            ->setMessage(__("Wait SMS"))
            // ->addAttribute('activated_code',$activated_code)
            // ->addAttribute('api_token',$user->api_token)
            ->build();
    }

    // public function verifiedPhone(VerifiedPhoneRequest $request) {
    //     $user = \Auth::user();
    //     if($user->user_type == User::TYPE_ADMIN) {
    //         return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
    //     }
    //     if ($user->activated_code != $request->code) {
    //         return (new API)->isError(__("Oops, This Code Is Incorrect"))->build();
    //     }
    //     $user->update([
    //         'activated_code'    => 0000,
    //         'phone_verified_at' => \Carbon\Carbon::now(),
    //     ]);
    //     \DB::table('users')->where('id',$user->id)->update([
    //         'phone_verified_at'=>\Carbon\Carbon::now()
    //     ]);
    //     $user = User::find($user->id);
    //     return (new API)->setStatusOk()
    //         ->setMessage(__("Now You Can Completed Your Information"))
    //         ->addAttribute('api_token',$user->api_token)
    //         ->build();
    // }

public function register(RegisterRequest $request) {
        $user = \Auth::user();
        // if($user->user_type == User::TYPE_ADMIN) {
        //     return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        // }
        // if (is_null($user->phone_verified_at)) {
        //     return (new API)->isError(__("عذرا هذا الجوال غير مفعل"))->build();
        // }
        $email = User::where('email',$request->email)->first();
        if (!is_null($email)) {
            return (new API)->isError(__("هذه البريد مستخدم من قبل"))->build();
        }
        $phone = User::where('phone',$request->phone)->first();
        if (!is_null($phone)) {
            return (new API)->isError(__("هذه الجوال مستخدم من قبل"))->build();
        }
        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'password'          => \Hash::make($request->password),
            // 'dev_token'         => $request->dev_token,
            'dev_token'        => $request->devices_token,
            'user_type'         => User::TYPE_CUSTOMER,
            'api_token'         => generate_api_token(),
            'completed_data'    => \Carbon\Carbon::now(),
            'phone_verified_at' => \Carbon\Carbon::now(),
        ]);
        return (new API)->setStatusOk()
            ->setMessage(__("User information"))
            ->setData(new UserResource($user))
            ->addAttribute('api_token',$user->api_token)
            ->build();
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        $user = User::where(['phone'=>$request->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__("الجوال غير مسجل لدينا"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        \DB::table('password_resets')->where(['phone'=>$request->phone])->delete();
        $newToken = rand(1000,9999);
        \DB::table('password_resets')->insert([
            'phone'=>$request->phone,
            'token'=>$newToken,
        ]);
        // Send SMS
        return (new API)->isOk(__("تحقق من الجوال الخاص بك"))->build();
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $getUserFormToken = \DB::table('password_resets')->where([
            'phone'=>$request->phone,
            //'token'=>$request->token
            ])->first();
        if (is_null($getUserFormToken)) {
            return (new API)->isError(__("This Token not fount"))->build();
        }
        $user = User::where(['phone'=>$getUserFormToken->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__("This phone not fount"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        $user->update([
            'password'  => \Hash::make($request->password),
            'api_token' => generate_api_token(),
        ]);
        //$getUserFormToken->delete();
        return (new API)->isOk(__("شكرا علي تغير كلمه المرور الخاصه بك"))->build();
    }
}
