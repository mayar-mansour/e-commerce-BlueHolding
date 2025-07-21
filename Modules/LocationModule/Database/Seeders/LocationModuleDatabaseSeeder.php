<?php

namespace Modules\LocationModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LocationModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            SeedCitiesTableSeeder::class,
            SeedCountriesTableSeeder::class,
            
        ]);

       
    }
}
