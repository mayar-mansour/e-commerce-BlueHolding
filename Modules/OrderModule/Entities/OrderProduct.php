<?php

namespace Modules\OrderModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ProductModule\Entities\Product;


class OrderProduct extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

 

 
}
