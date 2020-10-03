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
        // \App\Models\User::factory(10)->create();
       \App\Models\Hour::factory(24)->create();
       \App\Models\Day::factory(7)->create();
       \App\Models\Week::factory(2)->create();
    }
}
 