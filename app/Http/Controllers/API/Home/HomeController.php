<?php

namespace App\Http\Controllers\API\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Store\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Slider;
use App\Models\Category;
// Resources
use App\Http\Resources\API\Slider\SliderResource;
use App\Http\Resources\API\Categories\CategoriesResource;

class HomeController extends Controller
{
    public function index() {
        $data['sliders']     = SliderResource::collection(Slider::where('active',1)->get());
        $data['categories']  = CategoriesResource::collection(Category::where('active',1)->get());
        $offer      = Store::where(['offer'=>1])->orderBy('id','desc')->paginate();
        $moreChoice = Store::where(['more_choice'=>1])->orderBy('id','desc')->paginate();
        $recommend  = Store::where(['recommend'=>1])->orderBy('id','desc')->paginate();
        $unmissable = Store::where(['unmissable_offer'=>1])->orderBy('id','desc')->paginate();
        
        
        return (new API)->setStatusOk()
            ->setMessage(__("Home"))
            ->setData($data)
            ->addAttribute('offers',StoreResource::collection($offer))
            ->addAttribute('offers_pagination',api_model_set_paginate($offer))
            ->addAttribute('moreChoice',StoreResource::collection($moreChoice))
            ->addAttribute('moreChoice_pagination',api_model_set_paginate($moreChoice))
            ->addAttribute('recommend',StoreResource::collection($recommend))
            ->addAttribute('recommend_pagination',api_model_set_paginate($recommend))
            ->addAttribute('unmissable',StoreResource::collection($unmissable))
            ->addAttribute('unmissable_pagination',api_model_set_paginate($unmissable))
            ->build();
    }
    
    public function search(Request $request) {
        $stores = Store::where("name","like","%".$request->name."%")->orWhere("desc","like","%".$request->name."%")->paginate();
        return (new API)->setStatusOk()
            ->setMessage(__("نتائج البحث"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }
}
