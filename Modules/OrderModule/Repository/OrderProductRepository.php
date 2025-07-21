<?php

namespace Modules\OrderModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\OrderModule\Entities\Order;
use Modules\OrderModule\Entities\OrderProduct;
use Prettus\Repository\Eloquent\BaseRepository;

class  OrderProductRepository extends BaseRepository{

    public function model()
    {
        return OrderProduct::class;
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
        return Order::filter($request);
    }


}