<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddbrandResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'fullName' => $this->fullName,
            'tagLine' => $this->tagLine,
            'logo' =>  $this->concatenateLogoUrl($this->mainLogo),
            'smallLogo' => $this->concatenateLogoUrl($this->mainSmallLogo),
            'phone' => $this->phone,
            'email' => $this->email
        ];
    }

    private function concatenateLogoUrl($image)
    {
        if ($image != null) {
            if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
                return $image['base_url'] . $image['file_url'];
            } else {
                return $image['base_url'] . 'storage/' . $image['file_url'];
            }
        } else {
            return $image;
        }
    }
}
