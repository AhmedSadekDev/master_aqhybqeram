<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
use App\Models\Content;
use App\Models\Intro;
// Resources
use App\Http\Resources\API\Intro\IntroResource;

class SettingsController extends Controller
{
    public function index() {
        $data['social'] = [
            'facebook'    => getSettings('facebook'),
            'twitter'     => getSettings('twitter'),
            'instagram'   => getSettings('instagram'),
            // 'snapchat'    => getSettings('snapchat'),
        ];
        $data['info'] = [
            'website_name'      => getSettings('website_name','bella'),
            'website_logo'      => displayImage(getSettings('website_logo'),null),
            'phone'             => getSettings('phone',"0508562714"),
            'email'             => getSettings('email','info@bellezzaksa.com'),
            'whats_app'         => getSettings('whats_app',"0508562714"),
        ];
        $data['pages'] = Content::get(['id','title','value']);
        $data['payment_methods'] = [
            [
                'name'    =>  __('Mads'),
                'image'   =>  displayImage(getSettings('mads'),null),
            ],
            [
                'name'    =>  __('Visa'),
                'image'   =>  displayImage(getSettings('visa'),null),
            ],
            [
                'name'    =>  __('master'),
                'image'   =>  displayImage(getSettings('master'),null),
            ],
        ];
        $data['intro_page'] = IntroResource::collection(Intro::all());
        return (new API)->setStatusOk()
            ->setMessage(__("Settings Lists"))
            ->setData($data)
            ->build();
    }
}
