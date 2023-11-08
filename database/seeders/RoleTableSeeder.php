<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		Role::truncate();
        Role::create([
            'company_id' => 1,
            'name' => 'Administrator'
        ]);
        Role::create([
            'company_id' => 1,
            'name' => 'Ops support'
        ]);
        Role::create([
            'company_id' => 1,
            'name' => 'Client'
        ]);
    }
}
