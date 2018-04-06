<?php

use Illuminate\Database\Seeder;
use \App\Van;

class VanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Van::create([
            'plate_number' => 'AAA-123',
            'model_id' => '1',
            'seating_capacity' => '14',
            'status' => 'Active'
        ]);
    }
}
