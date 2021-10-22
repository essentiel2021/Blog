<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Crontab;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->hasArticles(5)->create();
       
    }
}
