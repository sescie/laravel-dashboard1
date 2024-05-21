<?php

namespace Database\Seeders;

use App\Models\Appliance;
use App\Models\energyPred;
use App\Models\energyUsed;
use App\Models\report;
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
        // User::factory(10)->create();

    
        Appliance::factory(1)->create();
        energyUsed::factory(24*30)->create();
        energyPred::factory(24*29)->create();
        report::factory(24*4)->create();
    }
}
