<?php

use Illuminate\Database\Seeder;
use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'last_name' => 'admin',
            'middle_name' => 'admin',
            'first_name' => 'admin',
            'username' => 'admin',
            'password' => '$2y$10$CEegohccFrevtvhZO1NxJ.sHxP8mTFFICDAmiqa50TGy72yufpGyC',
            'user_type' => 'Super-Admin',
            'status' => 'enable',
        ]);
        
        User::create([
            'last_name' => 'Teo',
            'middle_name' => 'Loren',
            'first_name' => 'Diaz',
            'username' => 'customer',
            'password' => '$2y$10$XJLLfpTnT0PRWizYi9YL7urIAm6qHB7j2Li5CUFZw2Jjzl7vDKP1C',
            'user_type' => 'Customer',
            'status' => 'enable'
        ]);
    }
}
