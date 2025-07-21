<?php

namespace Modules\ProductModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->name,
            'product_categories' => $this->categories->pluck('name'),
            'product_tags' => $this->tags->pluck('name'),
            'price' => $this->price,
            'average_rating' => $this->average_rating == 0 ? 0 : $this->average_rating,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'images' => $this->images->map(function ($image) {
                return $image->getImageFullPathAttribute();
            }),

        ];
    }
}
