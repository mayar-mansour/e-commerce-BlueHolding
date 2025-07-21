<?php

namespace Modules\OrderModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusesResource extends JsonResource
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
            "status" => $this->status,

        
        ];
    }
}
