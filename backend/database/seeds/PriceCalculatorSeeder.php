<?php

use Illuminate\Database\Seeder;
use App\PriceCalculator;
class PriceCalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceCalculator::insert([[
            'measurement' => '1',
            'desired_size' => '1.00',
            'desired_price' => '10.00',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ],[
            'measurement' => '2',
            'desired_size' => '1.00',
            'desired_price' => '5.00',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]]);
    }
}
