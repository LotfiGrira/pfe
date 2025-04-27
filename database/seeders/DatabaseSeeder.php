<?php

namespace Database\Seeders;
use Database\Seeders\UserSeeders;
use Database\Seeders\RolesSeeders;


use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this-> call([
            UserSeeders:: class,
            RolesSeeders:: class,
        ]);
    }
}
