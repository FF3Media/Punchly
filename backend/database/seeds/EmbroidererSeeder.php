<?php

use Illuminate\Database\Seeder;
use App\User;
class EmbroidererSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Embroiderer',
            'last_name' => 'User',
            'user_role' => '4',
            'email' => 'embroiderer@yopmail.com',
            'status' => '1',
            'password' => bcrypt('123123123'),
            'mobile' => '8888888888',
            'address' => 'United State',
            'email_verified_at' => date('Y-m-d h:i:s')
        ]);
    }
}
