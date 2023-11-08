<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleHasPermission;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		RoleHasPermission::truncate();
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 1
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 2
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 3
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 4
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 5
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 6
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 7
        ]);
        RoleHasPermission::create([
            'role_id' => 1,
            'permission_id' => 8
        ]);


        RoleHasPermission::create([
            'role_id' => 2,
            'permission_id' => 3
        ]);
        RoleHasPermission::create([
            'role_id' => 2,
            'permission_id' => 4
        ]);
        RoleHasPermission::create([
            'role_id' => 2,
            'permission_id' => 5
        ]);
        RoleHasPermission::create([
            'role_id' => 2,
            'permission_id' => 6
        ]);
        


        RoleHasPermission::create([
            'role_id' => 3,
            'permission_id' => 7
        ]);
        
        
    }
}
