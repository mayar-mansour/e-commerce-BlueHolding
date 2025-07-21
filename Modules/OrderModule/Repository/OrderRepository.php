<?php

namespace Modules\OrderModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\OrderModule\Entities\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class  OrderRepository extends BaseRepository{

    public function model()
    {
        return Order::class;
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
    function genOrderNu()
    {
        $latestNumber = Order::max('order_nu');
        if ($latestNumber == null) {
            $new_number = 1000;
        } else {
            $new_number = $latestNumber + 1;
        }
        return $new_number;
    }


}