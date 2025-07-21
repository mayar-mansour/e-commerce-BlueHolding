<?php

namespace Modules\RatingModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\RatingModule\Entities\ProductRatings;
use Prettus\Repository\Eloquent\BaseRepository;

class  RatingRepository extends BaseRepository{

    public function model()
    {
        return ProductRatings::class;
    }

    /**
     * ------------------------------
     * Filter
     * ------------------------------
     * 
     * Filter category according to sended array
     * 
     * @key parent_id
     * @key name
     * 
     * @param array $request
     * 
     * @return query
     */

    public function filter(array $request)
    {
        return ProductRatings::filter($request);
    }



}