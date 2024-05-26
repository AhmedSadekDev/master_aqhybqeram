<?php

namespace App\Http\Resources\API\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Subscriptions\SubscriptionsResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->showSubscription();
        $return = [
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            "avatar"            => display_image_by_model($this,"avatar"),
            // 'account_verified'  => (is_null($this->phone_verified_at)) ? false:true,
            'subscription'      => [
"status"        => true,
                "details"       => $data,
            ]
        ];
        return $return;
    }

    private function showSubscription() {
$item = $this->subscriptions()->first();

        return [
'id'                => ($item && $item->subscription) ? (int)$item->subscription->id : 0,
'name'              => ($item && $item->subscription) ? $item->subscription->name : '',
'start'             => ($item) ? $item->start : '',
'end'               => ($item) ? $item->end : '',
'price'             => ($item) ? (float)$item->price : 0,
'payment_status'    => ($item) ? $item->payment_status : '',
        ];
    }
}
