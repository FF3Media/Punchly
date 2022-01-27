<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalOrderFieldsToPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_details', function (Blueprint $table) {
          $table->integer('paypal_fee')->default(0)->after('pay_amount_received');
          $table->string('paypal_captured_id')->nullable()->after('pay_amount_received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_details', function (Blueprint $table) {
              $table->dropColumn('paypal_fee');
              $table->dropColumn('paypal_captured_id');
        });
    }
}
