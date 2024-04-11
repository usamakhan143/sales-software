<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "zipCode" => $this->zipCode,
            "country" => $this->country,
            "badge" => $this->badge,
            "status" => $this->status,
            "createdBy" => "Sales Executive",
            "notes" => $this->notes
        ];
    }
}
