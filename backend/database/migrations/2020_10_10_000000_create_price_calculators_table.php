<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_calculators', function (Blueprint $table) {
            $table->id();
            $table->enum('measurement',['1', '2'])->default('1')->comment('1 = Inches , 2 = Centimeter');
            $table->decimal('desired_size', 8, 2);
            $table->decimal('desired_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_calculators');
    }
}
