<?php

namespace App\Http\Resources\API\Rates;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RatesResource extends JsonResource
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
            'user'          => [
                "id"            => $this->user_id ?? '',
                "first_name"    => $this->user->first_name ?? '',
                "last_name"     => $this->user->last_name ?? '',
                "avatar"        => display_image_by_model($this->user ?? null,"avatar"),
            ],
            'rate'          => $this->rate,
            'message'       => $this->message,
            'created_at'    => $this->created_at,
        ];
    }
}
