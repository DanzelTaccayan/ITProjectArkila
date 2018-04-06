<?php

use Illuminate\Database\Seeder;
use \App\VanModel;

class VanModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VanModel::create([
            'model_id' => '1',
            'description' => 'Hi-Ace'
        ]);
    }
}
