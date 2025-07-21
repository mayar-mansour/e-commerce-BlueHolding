<?php

namespace Modules\LocationModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ClientModule\Entities\Client;
use Modules\LocationModule\Entities\City;
use Modules\StoreModule\Entities\Store;

class Area extends Model
{
    protected $table = "areas";
    protected $fillable = [ 'city_id','name_en', 'name_ar', 'latitude', 'longitude'];
    public $timestamps = false;



    function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'area_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'area_id');
    }
}
