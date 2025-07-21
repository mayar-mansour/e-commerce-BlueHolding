<?php

namespace Modules\LocationModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


use Modules\LocationModule\Entities\Country;

class CountryApiController extends Controller
{
    use ApiResponseHelper;
    public function __construct()
    {
    }


     
}
