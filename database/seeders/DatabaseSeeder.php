<?php

namespace Database\Seeders;

use App\Models\Crontab;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        Crontab::factory(5)->state(new Sequence(
            ['status'=> 'En attente'],
            ['status'=> 'Démarré'],
        ))
        ->create();
    }
}
