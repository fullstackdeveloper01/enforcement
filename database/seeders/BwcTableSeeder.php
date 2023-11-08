<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\Bwc;

class BwcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        //First truncate table
		Bwc::truncate();
        Bwc::insert([
            [
                'bwcNumber' => 'TRS6535',
                'name' => 'David Amal'
            ],
            [
                'bwcNumber' => 'GH56565',
                'name' => 'Hari'
            ]
        ]);
    }
}
