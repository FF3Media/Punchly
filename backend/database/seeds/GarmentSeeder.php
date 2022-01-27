<?php

use Illuminate\Database\Seeder;
use App\Garment;
class GarmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garment::insert([[
	        	'name' => 'Cotton',
	        	'description' => 'Cotton Cloth',
	        	'created_at' => date('Y-m-d h:i:s'),
	        	'updated_at' => date('Y-m-d h:i:s'),
        	],[
        		'name' => 'Silk',
	        	'description' => 'Silk Cloth',
	        	'created_at' => date('Y-m-d h:i:s'),
	        	'updated_at' => date('Y-m-d h:i:s'),
        	]
    	]);
    }
}
