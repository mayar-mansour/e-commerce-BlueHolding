<?php

namespace Modules\UserModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
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
            "token" => $this->token,
            "push_token" => $this->push_token != null ? $this->push_token : '',
            "name" => $this->name,
            "phone" => $this->phone != null ? $this->phone : '',
            'email' => $this->email != null ? $this->email : '',

        ];
    }
}
