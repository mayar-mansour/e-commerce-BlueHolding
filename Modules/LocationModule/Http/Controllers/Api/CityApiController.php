<?php

namespace Modules\LocationModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\LocationModule\Entities\City;
use Modules\LocationModule\Services\CityService;
use Modules\LocationModule\Transformers\CityResource;

class CityApiController extends Controller
{
    use ApiResponseHelper;
    private $cityService;
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    function getCitiesToCountry(Request $request){
        $country_id=1;
        $cities = $this->cityService->getByCountry($country_id);
        // dd($cities);
        $cities = CityResource::collection($cities);
        return $this->json(200, true,$cities, trans('messages.Success'),$request,auth()->user());
    }


    function saveCities()
    {
        $cities = "CAIRO
                    CAIRO
                    ALEXANDRIA";


        $cities_arr = explode("\n", $cities);
        $cities_arr = array_keys(array_flip($cities_arr));
        $renamed_cities = [];
        foreach ($cities_arr as $cty) {
            $renamed_cities[] = ucfirst(strtolower($cty));
        }
        sort($renamed_cities);
        $final_cities =  array_keys(array_flip($renamed_cities));
        foreach ($final_cities as $final_city) {
            City::create(['name' => $final_city, 'country_id' => 1]);
        }






        print_r($final_cities);
        exit;
    }

    public function listAllCities(Request $request){
        $cities = $this->cityService->getAll()->first()->paginate(30);
        $cities = CityResource::collection($cities);
        return $this->json(200, true,$cities, trans('messages.Success'),$request,auth()->user());
    }
}
