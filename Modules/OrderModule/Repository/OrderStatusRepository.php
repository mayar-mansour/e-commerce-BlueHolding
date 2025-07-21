<?php

namespace Modules\OrderModule\Repository;


use Modules\OrderModule\Entities\OrderStatus;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderStatusRepository extends BaseRepository
{
    function model()
    {
        return OrderStatus::class;
    }

}
