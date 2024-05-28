<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('actions_table_buttons')) {

    function actions_table_buttons($row, $route, $method = [])
    {
        $arrayDf = [
            'show'  => [
                'label' =>   __('Show'),
                'icon'  => 'fas fa-eye'
            ],
            'index'  => [
                'label' =>   __('Index'),
                'icon'  => 'fas fa-eye'
            ],
            'edit'  => [
                'label' =>   __('Edit'),
                'icon'  => 'fas fa-wrench'
            ],
            'destroy'  => [
                'label' =>   __('Delete'),
                'icon'  => 'fas fa-trash'
            ],
        ];
        $form = '';
        $array = (empty($method)) ? $arrayDf : $method;
        foreach ($array as $item) {
            if ($item == 'destroy') {
                if (is_array($row)) {
                    $pp = route("admin.{$route}.destroy", $row);
                } else {
                    $pp = route("admin.{$route}.destroy", $row->id);
                }
                $form .= '<form style="width: 36px;" action="' . $pp . '" method="post">
                <input name="_method" type="hidden" value="delete">
                <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
                <a class="btn btn-outline-danger btn-sm delete-record"><i class="' . $arrayDf[$item]['icon'] . '"></i></a>
                </form>';
            } else {
                if (is_array($row)) {
                    $pp = route("admin.{$route}.{$item}", $row);
                } else {
                    $pp = route("admin.{$route}.{$item}", $row->id);
                }
                $form .= '<a style="margin-left: 10px;" class="btn btn-outline-primary btn-sm " href="' . $pp . '"><i class="' . $arrayDf[$item]['icon'] . '"></i></a>';
            }
        }
        return $form;
    }
}

if(!function_exists('action_table_delete')) {
    function action_table_delete($route,$index = 0) {
        return '<form action="' . $route . '" method="post" id="form_'.$index.'">
        <input name="_method" type="hidden" value="delete">
        <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        <a class="btn btn-outline-danger btn-sm row_deleted" data-bs-toggle="modal" data-id="'.$index.'" data-bs-target="#staticBackdrop">
            <i class="bx bx-trash"></i>
        </a>
        </form>';
    }
}

if (!function_exists('api_model_set_paginate')) {

    function api_model_set_paginate($model)
    {
        $pagnation['total'] = $model->total();
        $pagnation['lastPage'] = $model->lastPage();
        $pagnation['perPage'] = $model->perPage();
        $pagnation['currentPage'] = $model->currentPage();
        return $pagnation;
    }
}



if (!function_exists('generator_activated_code')) {
    function generator_activated_code() {
        return rand(100000,999999);
    }
}

if (!function_exists('generator_password')) {
    function generator_password() {
        return 'BUG'.generator_activated_code()."aia";
    }
}

if (!function_exists('generate_api_token')) {
    function generate_api_token() {
        $random = \Illuminate\Support\Str::random(60);
        $check = \App\Models\User::where(['api_token' => $random])->first();
        if (!is_null($check)) {
            generate_api_token();
        }
        return $random;

    }
}

if (!function_exists('generate_email_hash')) {
    function generate_email_hash() {
        $random = \Illuminate\Support\Str::random(60);
        $check = \App\Models\User::where(['email_hash' => $random])->first();
        if (!is_null($check)) {
            generate_email_hash();
        }
        return $random;

    }
}

if (!function_exists('AppSettings')) {

    function AppSettings($var, $default = null)
    {
        $settings = Cache::rememberForever('saveSettings_'.\App::getLocale(),function() {
            return DB::table('site_settings')
                    ->join('site_settings_translations', 'site_settings_translations.settings_id', '=', 'site_settings.id')
                    ->select('site_settings.key','site_settings_translations.value')
                    ->where('site_settings_translations.locale', \App::getLocale())
                    ->get()->toArray();
        });
        $data = array_column($settings, 'value', 'key');
        return isset($data[$var]) ? $data[$var] : $default;
    }
}

if (!function_exists('imageUpload')) {
    function imageUpload($image, $path = null, $wh = [], $watermark = false) {
        $destinationPath = (is_null($path))? public_path('uploads'):public_path('uploads/'.$path);
        $mm = (is_null($path))?'uploads' :'uploads/'.$path;
        if(!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $imageName = random_int(11111,99999).'.'.$image->extension();
        $image->move($destinationPath, $imageName);
        return $mm.'/'.$imageName;
    }
}


if (!function_exists('display_image_by_model')) {
    function display_image_by_model($model,$key) {
        if(is_null($model)) {
            return "https://www.gravatar.com/avatar/".md5('123456');
        }
        if(is_null($model->$key)) {
            $name = explode(" ",$model->name);
            if(count($name) > 1) {
                $getName = $name[0].' '.$name[1];
            } else {
                $getName = $model->name;
            }
            return "https://eu.ui-avatars.com/api/?uppercase=true&name=".$getName."&background=random";
        }
        return url($model->$key);
    }
}

if (!function_exists('displayImage')) {

    function displayImage($image)
    {
        if(!is_null($image)) {
            if(is_file(public_path($image))) {
                return url($image);
            }
            return "https://www.gravatar.com/avatar/".md5('info@bugaia.net');
        }
        return "https://www.gravatar.com/avatar/".md5('info@bugaia.net');
    }
}


if (!function_exists('getSettings')) {
    function getSettings($var = null, $default = null,$trans = false)
    {
        $saloka = \App\Models\Setting::get()->toArray();
        $data = array_column($saloka, 'value', 'key');
        if(is_null($var)) {
            return $data;
        }
        return isset($data[$var]) ? $data[$var] : $default;
    }
}


if(!function_exists('PushFireBaseNotification')) {
    function PushFireBaseNotification($title,$message,$by = "admin",$message_to='all',$device_token) {
        $registrationIds = (is_array($device_token)) ? $device_token : [$device_token];
        $msg = [
            'title'         => $title,
            'type'          => $by,
            'tickerText'    => '',
            'vibrate'       => 1,
            'sound'         => 1,
            'largeIcon'     => 'large_icon',
            'smallIcon'     => 'small_icon',
        ];
        $msg['body'] = $message;
        if($message_to == "all") {
            $fields = [
                'notification' => $msg,
                'to'    => '/topics/all'
            ];
        } else {
            $fields = [
                'registration_ids' => $registrationIds,
                'notification' => $msg
            ];
        }
        $headers = [
            'Authorization: key='.getSettings('server_key','00'),
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
