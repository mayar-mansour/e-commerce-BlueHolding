<?php

namespace Modules\LocationModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // dd($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "country" => $this->country->name,
            "country_id" => $this->country_id
        ];
    }
}
