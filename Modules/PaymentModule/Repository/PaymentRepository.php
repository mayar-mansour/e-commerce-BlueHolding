<?php

namespace Modules\PaymentModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\PaymentModule\Entities\PaymentMethod;
use Modules\UserModule\Entities\ShippingAddress;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentRepository extends BaseRepository
{

    public function model()
    {
        return PaymentMethod::class;
    }




    


}
