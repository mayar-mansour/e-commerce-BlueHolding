<?php

namespace Modules\LocationModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LocationModule\Services\AreaService;
use Modules\LocationModule\Transformers\AreaResource;

class AreaApiController extends Controller
{
    use ApiResponseHelper;
    private $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }

    function getAreasToCity($city_id,Request $request){
      
        $areas = $this->areaService->getByCity($city_id);
        $areas = AreaResource::collection($areas);
        
       return $this->json(200, true,$areas, trans('messages.Success'),$request,auth()->user());
    }

}
