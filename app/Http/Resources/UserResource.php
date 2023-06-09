<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return[
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id,
            'photo' => $this->image ? url("storage/{$this->image}") : '',
            'online'=>false,
            'isMyFavorite'=>$this->favorite->count() > 0,
            'preference' => [
                'me_notify' => isset($this->preference) ? $this->preference->me_notify : true,
                'background_chat' => isset($this->preference) && $this->preference->image_background_chat ? url("storage/{$this->preference->image_background_chat}") : '',
            ]
        ];
    }
}
