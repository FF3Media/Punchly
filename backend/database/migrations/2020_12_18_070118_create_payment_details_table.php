<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->default('0');
            $table->string('order_group_id')->nullable();
            $table->string('currency')->default('usd');
            $table->string('invoice')->nullable();            
            $table->decimal('amount', $precision = 8, $scale = 2)->default('0');                                    
            $table->integer('st_status')->default(0)->comment('1 = requires_confirmation , 2 = requires_capture, 3 = succeeded , 4 = pay_authorize_created , 5 = pay_authorize_captured' );
            $table->string('st_payment_intent_id')->nullable();
            $table->decimal('st_amount_capturable', $precision = 8, $scale = 2)->default('0');
            $table->decimal('st_amount_received', $precision = 8, $scale = 2)->default('0');
            $table->string('st_charge_id')->nullable();
            $table->string('st_payment_method')->nullable();
            $table->string('pay_authorization_id')->nullable();
            $table->decimal('pay_amount_captured', $precision = 8, $scale = 2)->default('0');                        
            $table->decimal('pay_amount_received', $precision = 8, $scale = 2)->default('0');
            $table->string('pay_order_id')->nullable();    
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
        Schema::dropIfExists('payment_details');
    }
}
