<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Member::create([
            'member_id' => '1',
            'user_id' => '3',
            'last_name' => 'Santos',
            'first_name' => 'Manuel',
            'contact_number' => '+631223434342',
            'role' => 'driver',
            'address' => '31 Bengao st Baguio',
            'provincial_address' => '444 Agoo Pangasinan',
            'birth_date' => '1991-11-11',
            'birth_place' => 'Baguio City',
            'age' => '26',
            'citizenship' => 'Filipino',
            'civil_status' => 'Single',
            'person_in_case_of_emergency' => 'Sean Delos Santos',
            'emergency_address' => '31 Bengao st Baguio',
            'emergency_contactno' => '+632312323332',
            'license_number' => 'A23-12-321321',
            'status' => 'Active',
            'notification' => 'Enable',
            'expiry_date' => '2022-02-22',
            
        ]);
    }
}
