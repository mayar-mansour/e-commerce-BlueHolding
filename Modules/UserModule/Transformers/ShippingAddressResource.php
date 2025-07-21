<?php

namespace Modules\UserModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            "id" => $this->id,
            "additional_phone" => $this->additional_phone ?? null,
            "lat" => $this->lat ?? null,
            "lng" => $this->lng ?? null,
            "address_title" => $this->address_title ?? null,
            "address" => $this->address ?? null,
            "city_id" => $this->city_id ?? null,
            "area_id" => $this->area_id ?? null,
            "distinct_mark" => $this->distinct_mark ?? null,
        ];
        
    }
}
