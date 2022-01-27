<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('currency',10)->nullable();
           // $table->integer('duration_in_months')->default('0');
            $table->integer('max_redemptions')->default('0');
            $table->longText('coupon_id')->nullable();
            $table->decimal('amount_off', 8, 2)->nullable();
            $table->decimal('percent_off', 8, 2)->nullable();
            $table->string('funding')->nullable();            
            $table->string('description')->nullable();            
            $table->dateTime('redeem_by')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('times_redeemed')->default('0');
            $table->string('last4')->nullable();
            $table->enum('valid',['1', '0'])->default('1');
            $table->enum('publish',['0', '1'])->default('0');
            //$table->enum('duration',['once', 'forever','repeating'])->default('once');
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
        Schema::dropIfExists('coupons');
    }
}
