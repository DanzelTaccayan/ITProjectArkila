<?php

use Illuminate\Database\Seeder;
use \App\Feature;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Feature::create([
                'description' => 'Online Reservation',
                'Status' => 'enable'
            ]);

            Feature::create([
                'description' => 'Walk-in Reservation',
                'Status' => 'enable'
            ]);

            Feature::create([
                'description' => 'Online Van Rental',
                'Status' => 'enable'
            ]);

            Feature::create([
                'description' => 'Walk-in Van Rental',
                'Status' => 'enable'
            ]);

            Feature::create([
                'description' => 'Driver Module',
                'Status' => 'enable'
            ]);

            Feature::create([
                'description' => 'Customer Module',
                'Status' => 'enable'
                ]);

            Feature::create([
                'description' => 'SetUp Page',
                'Status' => 'enable'
                ]);
    }
}
