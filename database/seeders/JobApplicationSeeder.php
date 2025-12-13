<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;

class JobApplicationSeeder extends Seeder
{
    public function run()
    {
        JobApplication::factory()->count(5)->create();
    }
}
