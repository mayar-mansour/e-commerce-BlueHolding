<?php

namespace Modules\LocationModule\Repository;

use Modules\LocationModule\Entities\Area;
use Prettus\Repository\Eloquent\BaseRepository;

class AreaRepository extends BaseRepository
{

    public function model()
    {
        return Area::class;
    }
    function findwith($data,$array_with)
    {
        return Area::Where($data)->with($array_with)->get();
    }
 
}
