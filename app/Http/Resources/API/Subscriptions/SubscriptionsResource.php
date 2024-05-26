<?php

namespace App\Http\Resources\API\Subscriptions;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsResource extends JsonResource
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
            'id'     => $this->id,
            'name'   => $this->name,
            'price'  => $this->price,
            'month'  => $this->month,
            'image'  => display_image_by_model($this,'image'),
        ];
    }
}
