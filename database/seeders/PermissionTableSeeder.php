<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		Permission::truncate();        
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Admin',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Case Management',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Setup',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Machine Control',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Enviro Master',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Service Requests',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Reports',
        ]);
        Permission::create([
            'name' => 'manage',
            'description' => 'manage',
            'category' => 'Letters',
        ]);

    }
}
