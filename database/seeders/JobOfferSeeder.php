<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobOffer;

class JobOfferSeeder extends Seeder
{
    public function run()
    {

        JobOffer::factory()->count(10)->create();
    }
}
