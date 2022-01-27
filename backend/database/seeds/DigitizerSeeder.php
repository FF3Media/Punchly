<?php

use Illuminate\Database\Seeder;
use App\User;
class DigitizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Digitizer',
            'last_name' => 'User',
            'user_role' => '3',
            'email' => 'digitizer@yopmail.com',
            'status' => '1',
            'password' => bcrypt('123123123'),
            'mobile' => '7777777777',
            'address' => 'United State',
            'email_verified_at' => date('Y-m-d h:i:s')
        ]);
    }
}
