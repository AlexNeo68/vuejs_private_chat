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
        \App\Models\User::factory()->create([
            'email' => 'info1@makewww.ru',
            'name' => 'Info 1',
        ]);
        \App\Models\User::factory()->create([
            'email' => 'info2@makewww.ru',
            'name' => 'Info 2',
        ]);
        \App\Models\User::factory()->create([
            'email' => 'info3@makewww.ru',
            'name' => 'Info 3',
        ]);
    }
}
