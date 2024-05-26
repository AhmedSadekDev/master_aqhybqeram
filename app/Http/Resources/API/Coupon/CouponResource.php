<?php

namespace App\Http\Resources\API\Coupon;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'id'      => $this->id,
            'name'    => $this->name,
            'desc'    => $this->desc,
            'code'    => $this->code,
            'expire'  => $this->expire,
            'store'   => [
                'name'          => $this->store->name ?? '',
                'logo'          => display_image_by_model($this->store,'logo'),
            ],
        ];
    }
}
