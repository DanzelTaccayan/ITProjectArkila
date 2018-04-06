<?php

use Illuminate\Database\Seeder;
use \App\Terminal;

class TerminalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Terminal::create([
            'terminal_id' => '1',
            'description' => 'Baguio City',
            'booking_fee' => '20.00'
        ]);

    }

}
