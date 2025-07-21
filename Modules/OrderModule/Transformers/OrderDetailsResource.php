<?php

namespace Modules\OrderModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            "order_num"=> $this->order_nu,
            "pharmacy"=>$this->pharmacy->name,
            "payment" => $this->payment_method->name,
            "transaction_id" => $this->transaction_id,
            "status" => $this->status->status,
            "coupon" => $this->coupon_id === 0 ? Null : $this->coupon->coupon_value,
            "total_amount" => $this->total_amount ? $this->total_amount : Null,
            "delivery_fees" => $this->delivery_fees ? $this->delivery_fees : Null,
            "shipping_address" => $this->shipping_address ? $this->shipping_address->address : Null,
            "is_paid" => $this->is_paid == 1 ? "Paid" : "Not Paid", 
            "net_amount" => $this->net_amount,
            "notes" => $this->notes,
       
        ];
    }
}
