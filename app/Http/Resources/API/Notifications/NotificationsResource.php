<?php

namespace App\Http\Resources\API\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!in_array(\Auth::user()->id,$this->users ?? [])) {
            return;
        }
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'message'           => $this->showMessage(),
            'type'              => $this->type,
            'model_id'          => $this->model_id,
        ];
    }
}
