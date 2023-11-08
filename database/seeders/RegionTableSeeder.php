<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\Region;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		Region::truncate();
        Region::insert([
            ['region' => 'North Wales'],
            ['region' => 'South West'],
            ['region' => 'South East'],
            ['region' => 'North East'],
            ['region' => 'South Wales']
        ]);
    }
}
