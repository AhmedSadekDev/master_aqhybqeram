<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\Notification;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Notifications\NotificationsResource;

class NotificationsController extends Controller
{
    public function index() {
        $lists = Notification::whereIn('user_id',[0,\Auth::user()->id])->orderBy('id','desc')->get();
        $array = [];
        foreach($lists as $list) {
            if(in_array(\Auth::user()->id,$list->users ?? [])) {
                $array[] = [
                    'id'                => $list->id,
                    'title'             => $list->title,
                    'message'           => $list->showMessage(),
                    'type'              => $list->type,
                    'model_id'          => $list->model_id,
                    ];
            }
        }
        return (new API)->setStatusOk()
            ->setMessage(__("الإشعارات"))
            ->setData($array)
            // ->addAttribute('pagination',api_model_set_paginate($lists))
            ->build();
    }

    public function destroy(Notification $notification) {
        if($notification->user_id == \Auth::user()->id) {
            $notification->delete();
            return (new API)->isOk("تم مسح الإشعار بنجاح")->build();
        }
        if($notification->user_id == 0) {
            $ids = $notification->users ?? [];
            if(in_array(\Auth::user()->id,$ids)) {
                // unset($ids[\Auth::user()->id]);
                $ids = array_diff($ids,[\Auth::user()->id]);
                // dd($ids);
                $notification->update(['users'=>$ids]);
            }
            return (new API)->isOk("تم مسح الإشعار بنجاح")->build();
        }
        return (new API)->isError(" للاسف لايمكن مسح هذا الإشعار")->build();
    }
}
