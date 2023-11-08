<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Letter\Group;
use App\Models\Letter\Subgroup;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::insert([
            [
                'name' => 'Reminder Letters',
            ],
            [
                'name' => 'Appeal Letters',
            ],
            [
                'name' => 'Extension Letters',
            ],
            [
                'name' => 'Court Letters',
            ],
            [
                'name' => 'AdHoc Communications',
            ],
        ]);

        Subgroup::insert([
            [
                'group_id' => 1,
                'name' => 'Postal Letter'
            ],
            [
                'group_id' => 1,
                'name' => '1st Reminder'
            ],
            [
                'group_id' => 1,
                'name' => '2nd Reminder'
            ],
            [
                'group_id' => 1,
                'name' => 'Other Reminder'
            ],

            [
                'group_id' => 2,
                'name' => 'Appeal Lodged'
            ],
            [
                'group_id' => 2,
                'name' => 'Appeal Upheld'
            ],
            [
                'group_id' => 2,
                'name' => 'Appeal Declined'
            ],
            [
                'group_id' => 2,
                'name' => 'Other Appeals'
            ],

            [
                'group_id' => 3,
                'name' => 'Extension on Payment'
            ],

            [
                'group_id' => 4,
                'name' => 'Court Letters'
            ],

            [
                'group_id' => 5,
                'name' => 'AdHoc Communications'
            ]
        ]);
        
    }
}
