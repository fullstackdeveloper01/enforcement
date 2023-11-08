<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ApplicantTypeSeeder::class,
            WasteTypeSeeder::class,
            BwcTableSeeder::class,
            CompanyRegisteredTypeSeeder::class,
            CompanyTableSeeder::class,
            LovSeeder::class,
            ManualRepresentationReasonSeeder::class,
            OffenceGroupTableSeeder::class,
            PermissionTableSeeder::class,
            ProducedWasteTransferSeeder::class,
            RegionTableSeeder::class,
            RepresentationAcceptReasonSeeder::class,
            RepresentationDeclineReasonSeeder::class,
            RoleTableSeeder::class,
            RoleHasPermissionSeeder::class,
            SiteSeeder::class,
            UserSeeder::class,
            LetterSeeder::class,
        ]);
    }
}
