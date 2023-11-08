<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AssignedSite;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		User::truncate();
        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'Hari Rao',
            'first_name' => 'Hari',
            'last_name' => 'Rao',
            'email' => 'hari@powermetrics.co.uk',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
            'is_officer' => 1,
            'operator_number' => '1',

        ]);
        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'David Amal',
            'first_name' => 'David',
            'last_name' => 'Amal',
            'email' => 'david.amal@nationalenforcementsolutions.co.uk',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
            'operator_number' => '2',

        ]);

        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'Awais Khalid',
            'first_name' => 'Awais',
            'last_name' => 'Khalid',
            'email' => 'awais.khalid800@gmail.com',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
            'is_officer' => 1,
            'operator_number' => '3',
            'pin_number' => '1638'
        ]);
        
        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'Salman Ahmad',
            'first_name' => 'Salman',
            'last_name' => 'Ahmad',
            'email' => 'naved.nice@gmail.com',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
            // 'is_officer' => 1
        ]);
        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'Rebecca',
            'first_name' => 'Rebecca',
            'last_name' => 'bugby',
            'email' => 'rebecca.bugby@nationalenforcementsolutions.co.uk',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
        ]);
        User::create([
            'role_id'=>1,
            'company_id'=>1,
            'name' => 'Luke Williams',
            'first_name' => 'Luke',
            'last_name' => 'Williams',
            'email' => 'luke.williams@nationalenforcementsolutions.co.uk',
            'password' => bcrypt('admin@123'),
            'two_factor_status' => 1,
        ]);

        AssignedSite::insert([
            [
                'user_id' => 1,
                'site_id' => 1
            ],
            [
                'user_id' => 1,
                'site_id' => 2
            ],
            [
                'user_id' => 1,
                'site_id' => 3
            ],
            [
                'user_id' => 2,
                'site_id' => 1
            ],
            [
                'user_id' => 2,
                'site_id' => 2
            ],
            [
                'user_id' => 2,
                'site_id' => 3
            ],
            [
                'user_id' => 3,
                'site_id' => 1
            ],
            [
                'user_id' => 3,
                'site_id' => 2
            ],
            [
                'user_id' => 3,
                'site_id' => 3
            ]
        ]);
    }
}
