<?php

namespace Modules\OrderModule\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\SpecialistModule\Entities\Category;
use Modules\CouponModule\Entities\Coupon;
use Modules\ProductModule\Entities\Product;
use Modules\PaymentModule\Entities\PaymentMethod;
use Modules\PharmacyModule\Entities\Pharmacy;
use Modules\SettingModule\Entities\Setting;
use Modules\UserModule\Entities\ShippingAddress;
use Modules\UserModule\Entities\User;

class Order extends Model
{
    protected $guarded = [];




    //Relations 

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }



    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }



    // order Address
    public function shipping_address()
    {

        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }
}
