<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Master',
            'last_name' => 'Admin',
            'user_role' => '1',
            'email' => 'admin@yopmail.com',
            'status' => '1',
            'password' => bcrypt('123123123'),
            'mobile' => '9999999999',
            'address' => 'United State',
            'email_verified_at' => date('Y-m-d h:i:s')
        ]);
    }
}
