<?php

namespace Modules\UserModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "push_token" => $this->push_token != null ? $this->push_token : '',
            "name" => $this->name ?? null,
            "phone" => $this->phone ?? null,
            "email" => $this->email ?? null,
         
        ];
    }
}
