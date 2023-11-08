<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\CompanyRegisteredType;

class CompanyRegisteredTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		CompanyRegisteredType::truncate();
        CompanyRegisteredType::insert(array(
            0 => array('registered_type' => 'Carrier', 'status' => '1'),
            1 => array('registered_type' => 'Broker', 'status' => '1'),
            2 => array('registered_type' => 'Dealer - Lower Tier', 'status' => '1'),
            3 => array('registered_type' => 'Dealer - Upper tier', 'status' => '1'),
        ));
    }
}
