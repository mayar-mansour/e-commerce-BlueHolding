<?php

namespace Modules\LocationModule\Repository;

use Modules\LocationModule\Entities\Country;
use Prettus\Repository\Eloquent\BaseRepository;

class CountryRepository extends BaseRepository
{

    public function model()
    {
        return Country::class;
    }
    
}
