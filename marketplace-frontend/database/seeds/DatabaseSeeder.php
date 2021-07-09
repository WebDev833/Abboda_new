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
        $this->call(UserTableSeeder::class);
        $this->call(AppSettingsSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(CompanyTypeTableSeeder::class);
        $this->call(SearchtagTableSeeder::class);
    }
}
