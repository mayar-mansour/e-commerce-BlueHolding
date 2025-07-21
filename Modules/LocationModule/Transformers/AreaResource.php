<?php

namespace Modules\LocationModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            "name" => $this->name_ar,
            "city" => $this->city->name_ar,
            "city_id" => $this->city_id
        ];
    }
}
