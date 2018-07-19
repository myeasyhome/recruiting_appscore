<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //insert demo data
        //demo data for roles table
        DB::insert('INSERT INTO `recruiting_appscore`.`roles` (`name`, `updated_at`, `created_at`) VALUES (\'iOS Developer\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`roles` (`name`, `updated_at`, `created_at`) VALUES (\'Android Developer\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`roles` (`name`, `updated_at`, `created_at`) VALUES (\'PHP Developer\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`roles` (`name`, `updated_at`, `created_at`) VALUES (\'Tech Lead\', NOW(), NOW())');

        //demo data for recruiters table
        DB::insert('INSERT INTO `recruiting_appscore`.`recruiters` (`name`, `updated_at`, `created_at`) VALUES (\'Clicks IT Recruitment\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`recruiters` (`name`, `updated_at`, `created_at`) VALUES (\'Method Recruitment\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`recruiters` (`name`, `updated_at`, `created_at`) VALUES (\'Yolk Agency\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`recruiters` (`name`, `updated_at`, `created_at`) VALUES (\'Sirius Technology\', NOW(), NOW())');

        //demo data for clients table
        DB::insert('INSERT INTO `recruiting_appscore`.`clients` (`name`, `updated_at`, `created_at`) VALUES (\'Medi Bank\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`clients` (`name`, `updated_at`, `created_at`) VALUES (\'Samsung\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`clients` (`name`, `updated_at`, `created_at`) VALUES (\'Telestra\', NOW(), NOW())');
        DB::insert('INSERT INTO `recruiting_appscore`.`clients` (`name`, `updated_at`, `created_at`) VALUES (\'Boxer\', NOW(), NOW())');
    }
}
