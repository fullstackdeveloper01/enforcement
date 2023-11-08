<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		Company::truncate();
        Company::create([
            'user_id' => 1,
            'name' => 'ABC LTD',
            'email' => 'abc@yopmail.com',
            'telephone' => '7000000000',
            'address' => '120 Madison Ave New York NY 10016 USA'
        ]);
    }
}
