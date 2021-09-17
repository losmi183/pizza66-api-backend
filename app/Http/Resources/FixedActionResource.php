<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FixedActionResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "day" => $this->day,
            "fixed" => $this->fixed,
            "old_price" => $this->old_price,
            "new_price" => $this->new_price,
            "description" => $this->description,
            "status" => $this->status,
            "image" => $this->image
        ];
    }
}
