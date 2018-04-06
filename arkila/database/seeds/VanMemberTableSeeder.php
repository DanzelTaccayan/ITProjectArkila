<?php

use Illuminate\Database\Seeder;

class VanMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member_van')
            ->insert([
                'member_id' => '1',
                'plate_number' => 'AAA-123'
            ]);
        
        DB::table('member_van')
            ->insert([
                'member_id' => '2',
                'plate_number' => 'AAA-123'
            ]);
    }
}
