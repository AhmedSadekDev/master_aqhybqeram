<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Notification\CreateNotificationRequest;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index() {

        $breadcrumb = [
            'title' =>  __("إرسال إشعارات"),
            'items' =>  [
                [
                    'title' =>  __("إرسال إشعارات"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = User::where('user_type',User::TYPE_CUSTOMER)->get();
        return view('dashboard.pages.notifications.index',[
            'breadcrumb'    =>  $breadcrumb,
            'lists'         =>  $lists,
        ]);
    }

    public function store(CreateNotificationRequest $request) {
        if($request->customer == 0) {

            Notification::create([
                'user_id'   => 0,
                'model_id'  => 0,
                'title'     => $request->title,
                'message'   => $request->message,
                'type'      => "admin",
                'users'     => User::pluck('id')->toArray(),
            ]);

            PushFireBaseNotification($request->title,$request->message,"admin","all",[]);
        } else {
            $user = User::where('id',$request->customer)->first();
            if(!is_null($user)) {
                Notification::create([
                    'user_id'   => $user->id,
                    'model_id'  => 0,
                    'title'     => $request->title,
                    'message'   => $request->message,
                    'type'      => "admin",
                    'users'     => [$user->id],
                ]);
                PushFireBaseNotification($request->title,$request->message,"admin","customers",$user->dev_token);
            }
        }
        return redirect()->route('dashboard.notifications.index')->with('success', __("تم إرسال الرساله بنجاح"));
    }

}
