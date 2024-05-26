<?php

namespace App\Http\Resources\API\Store;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Categories\CategoriesResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'desc'          => $this->desc,
            'logo'          => display_image_by_model($this,'logo'),
            'cover'         => display_image_by_model($this,'cover'),
            'rate'          => $this->rate,
            'if_favorite'   => $this->isFavorite(),
            'categories'    => CategoriesResource::collection($this->categories()->orderBy('id','desc')->get()),
        ];
    }
    
    public function isFavorite() {
        if(\Auth::check() == false) {
            return false;
        }
        $storeIds = \Auth::user()->fav()->pluck('store_id')->toArray();
        if(in_array($this->id,$storeIds)) {
            return true;
        } else {
            return false;
        }
    }
}
