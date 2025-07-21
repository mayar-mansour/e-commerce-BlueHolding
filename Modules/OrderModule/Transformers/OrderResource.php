<?php

namespace Modules\OrderModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $productData = [];

        foreach ($this->orderproducts as $product_item) {
            $productData[] = [
                'id' => $product_item->product_id,
                'name' => $product_item->product_name,
                'price' => $product_item->item_price,
            ];
        }
        $createdAt = $this->created_at;
        $createdDate = date('Y-m-d', strtotime($createdAt));
        $createdTime = date('H:i:s', strtotime($createdAt));

        return [
            "id" => $this->id,
            "order_num" => $this->order_nu,
            "payment" => $this->payment_method->name,
            "status" => $this->status->status,
            "order_status_id" => $this->status_id,
            "transaction_id" => $this->transaction_id,
            "total_amount" => $this->total_amount ? $this->total_amount : Null,
            "delivery_fees" => $this->delivery_fees ? $this->delivery_fees : Null,
            "shipping_address" => $this->shipping_address ? $this->shipping_address->address : Null,
            "is_paid" => $this->is_paid == 1 ? "Paid" : "Not Paid",
            "net_amount" => $this->net_amount,
            "notes" => $this->notes,
            "product_data" => $productData,
            "created_at" => $this->created_at,
            "created_date" => $createdDate,
            "created_time" => $createdTime,

        ];
    }
}
