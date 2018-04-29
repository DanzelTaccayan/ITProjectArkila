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
            'password' => '$2y$10$9cyV8.dgRdGfOwVSpnUtb.ft4QdFUm5w5dyaMeSzv3i6v799W4W3m',
            'user_type' => 'Super-Admin',
            'status' => 'enable',
        ]);
        
        User::create([
            'last_name' => 'Teo',
            'middle_name' => 'Loren',
            'first_name' => 'Diaz',
            'username' => 'customer',
            'password' => '$2y$10$9cyV8.dgRdGfOwVSpnUtb.ft4QdFUm5w5dyaMeSzv3i6v799W4W3m',
            'user_type' => 'Customer',
            'status' => 'enable'
        ]);
        
         User::create([
            'id' => 3,
            'last_name' => 'Santos',
            'first_name' => 'Manuel',
            'username' => 'mSantos',
            'password' => '$2y$10$rnqQkdBAevbkFVDU9Ucwyuobhea5gDZpJ..FZqEZBxEr1oECnq.1C',
            'user_type' => 'Driver',
            'status' => 'enable'
        ]);
    }
}
