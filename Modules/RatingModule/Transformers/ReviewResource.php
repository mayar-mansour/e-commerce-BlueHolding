<?php
namespace Modules\RatingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "star" => $this->star,
            "comment" => $this->comment,
        ];
    }
}
