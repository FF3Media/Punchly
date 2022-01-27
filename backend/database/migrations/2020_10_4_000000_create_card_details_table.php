<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('card_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('funding')->nullable();
            $table->integer('exp_month')->default('0');
            $table->integer('exp_year')->default('0');
            $table->string('last4')->nullable();
            $table->enum('status',['1', '0'])->default('0');
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
        Schema::dropIfExists('card_details');
    }
}
