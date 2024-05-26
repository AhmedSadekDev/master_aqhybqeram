<?php

namespace App\Http\Controllers\API\Fav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Store;
// Resources
use App\Http\Resources\API\Store\StoreResource;

class FavController extends Controller
{
    public function index () {
        $stores = \Auth::user()->fav()->orderBy('id','desc')->paginate();
        return (new API)
            ->isOk(__("Fav Stores lists"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }

    public function store(Store $store) {
        $ids = \Auth::user()->fav()->pluck('store_id')->toArray() ?? [];
        $ids[] = $store->id;
        \Auth::user()->fav()->sync($ids);
        return (new API)->isOk(__("Added"))->build();
    }

    public function destroy(Store $store) {
        \DB::table('stores_fav')->where(['user_id'=>\Auth::user()->id,'store_id'=>$store->id])->delete();
        return (new API)->isOk(__("Deleted"))->build();
    }
}
