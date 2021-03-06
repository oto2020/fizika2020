<?php

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
        $this->call(SchoolsSeeder::class);
        $this->call(SchoolClassesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SectionsSeeder::class);
        $this->call(ThemesSeeder::class);
    }
}
