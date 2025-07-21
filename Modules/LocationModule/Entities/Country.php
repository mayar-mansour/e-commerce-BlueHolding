<?php

namespace Modules\LocationModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\LocationModule\Entities\City;
use Modules\StoreModule\Entities\Store;

class Country extends Model
{
    protected $table = "countries";
    protected $fillable = ['name_en','name_ar', 'code', 'currency'];
     public $timestamps = false;

    function cities()
    {
        return $this->hasMany(City::class,'country_id');
    }

    
    function stores()
    {
        return $this->hasMany(Store::class,'country_id');
    }


    public function getNameAttribute()
    {
        $lang = config('app.locale') == 'ar' ? '_ar' : '_en';
        return $this->attributes['name' . $lang];
    }
    
}
