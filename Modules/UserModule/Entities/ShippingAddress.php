<?php

namespace Modules\UserModule\Entities;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\CartModule\Entities\Cart;
use Modules\LocationModule\Entities\Area;
use Modules\LocationModule\Entities\City;
use Modules\MedicineModule\Entities\Medicine;
use Modules\OrderModule\Entities\Order;
use Modules\PharmacyModule\Entities\Pharmacy;

class ShippingAddress extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $guarded = [];

  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }



}
