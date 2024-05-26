<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Category;
// Resources
use App\Http\Resources\API\Categories\CategoriesResource;
use App\Http\Resources\API\User\UserResource;
use App\Http\Resources\API\Store\StoreResource;

class CategoryController extends Controller
{
    public function index (Request $request) {
        $categories = Category::all();
        return (new API)
            ->isOk(__("Categories lists"))
            ->setData(CategoriesResource::collection($categories))
            ->build();
    }

    public function show(Category $category) {
        $stores = $category->stores()->where('stores.active',1);
        if(request()->has('rate')) {
            if(request('rate') == "desc") {
                $stores = $stores->orderBy('stores.rate','desc');
            } else {
                $stores = $stores->orderBy('stores.rate','asc');
            }
        }
        $stores = $stores->paginate();
        return (new API)
            ->isOk(__("Stores lists"))
            ->setData(StoreResource::collection($stores))
            ->addAttribute('pagination',api_model_set_paginate($stores))
            ->build();
    }
}
