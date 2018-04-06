<?php

use Illuminate\Database\Seeder;
use \App\FeesAndDeduction;

class FeesAndDeductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeesAndDeduction::create([
            'description' => 'Community Fund',
            'amount' => '5',
            'type' => 'Fee'
        ]);
        
        FeesAndDeduction::create([
            'description' => 'PWD/Senior',
            'amount' => '20',
            'type' => 'Discount'
        ]);
        
        FeesAndDeduction::create([
            'description' => 'SOP',
            'amount' => '100',
            'type' => 'Fee'
        ]);
    }
}
