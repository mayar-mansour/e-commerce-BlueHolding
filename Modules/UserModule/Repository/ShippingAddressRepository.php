<?php

namespace Modules\UserModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\UserModule\Entities\ShippingAddress;
use Prettus\Repository\Eloquent\BaseRepository;

class ShippingAddressRepository extends BaseRepository
{

    public function model()
    {
        return ShippingAddress::class;
    }




    


}
