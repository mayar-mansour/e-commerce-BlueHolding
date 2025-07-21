<?php

namespace Modules\ProductModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRatingResource extends JsonResource
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
            "product_id" => $this->product_id,
            "rate" => isset($this->star) ? $this->star : 0,
            "comment" => isset($this->comment) ? $this->comment : null,
        ];
    }
}
