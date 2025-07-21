<?php

namespace Modules\LocationModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\LocationModule\Entities\City;
use Prettus\Repository\Eloquent\BaseRepository;

class CityRepository extends BaseRepository
{

    public function model()
    {
        return City::class;
    }
    function findwith($data, $array_with)
    {
        return City::Where($data)->with($array_with)->get();
    }

    public function findwhereBySort($country_id)
    {
        return City::where(['country_id' => $country_id])
            ->orderBy(DB::raw("name_en <> 'Riyadh',name_en"))->get();
    }
}
