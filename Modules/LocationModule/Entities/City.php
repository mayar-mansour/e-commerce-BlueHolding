<?php

namespace Modules\LocationModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\LocationModule\Entities\Country;
use Modules\LocationModule\Entities\Area;
use Modules\StoreModule\Entities\Store;

class City extends Model
{
    protected $table = "cities";
    protected $fillable = ['country_id','name_ar','name_en',];
    public $timestamps = false;

    function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

   
    

    public function getNameAttribute()
    {
        $lang = config('app.locale') == 'ar' ? '_ar' : '_en';
        return $this->attributes['name' . $lang];
    }
    
}
