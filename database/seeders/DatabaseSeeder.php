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
        $this->call(PermissionSeeder::class);
        $this->call(TypeOfUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GradeTypeSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(SubjectsSeeder::class);
    }
}
