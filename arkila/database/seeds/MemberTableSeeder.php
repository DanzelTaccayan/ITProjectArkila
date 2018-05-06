<?php

use Illuminate\Database\Seeder;
use App\Member;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         Member::create([
            'member_id' =>'1',
            'last_name' => 'Dalisay',
            'first_name' => 'Cardo',
            'contact_number' => '122-456-4342',
            'role' => 'Operator',
            'address' => '31 upper QM st Baguio',
            'provincial_address' => '4 Dagupan Pangasinan',
            'person_in_case_of_emergency' => 'Tom Santos',
            'emergency_address' => '31 Bengao st Baguio',
            'emergency_contactno' => '635-232-3332',
            'license_number' => 'A23-12-377771',
            'status' => 'Active',
            'notification' => 'Enable',
            'expiry_date' => '02/22/2025'
            
        ]);
        
        Member::create([
            'member_id' =>'2',
            'user_id' => '3',
            'operator_id' => '1',
            'last_name' => 'Santos',
            'first_name' => 'Manuel',
            'contact_number' => '122-343-4342',
            'role' => 'Driver',
            'address' => '31 Bengao st Baguio',
            'provincial_address' => '444 Agoo Pangasinan',
            'person_in_case_of_emergency' => 'Sean Delos Santos',
            'emergency_address' => '31 Bengao st Baguio',
            'emergency_contactno' => '231-232-3332',
            'license_number' => 'A23-12-321321',
            'status' => 'Active',
            'notification' => 'Enable',
            'expiry_date' => '02/12/2022'
            
        ]);
        
    }
}
