<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        \App\Models\Hour::factory(24)->create();
        \App\Models\Day::factory(7)->create();
        \App\Models\Week::factory(2)->create();


        DB::table('statuses')->insert([
            'name' => 'Лид',
        ]);

        DB::table('statuses')->insert([
            'name' => 'Клиент',
        ]);
        
        DB::table('types')->insert([
            'name' => 'Свободное посещение',
        ]);

        DB::table('types')->insert([
            'name' => 'По абонименту',
        ]);
    }
}
