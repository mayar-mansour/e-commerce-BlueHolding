<?php

namespace Modules\PaymentModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Modules\PaymentModule\Entities\PaymentMethod;

class PaymentModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('payment_methods')->truncate();
        PaymentMethod::create(['name' => "Visa"]);
        PaymentMethod::create(['name' => "Cash"]);
    }
}
