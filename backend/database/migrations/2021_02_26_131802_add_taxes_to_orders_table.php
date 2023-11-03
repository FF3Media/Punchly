<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxesToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('gst',8,2)->default('0');
            $table->decimal('rst',8,2)->default('0');
            $table->decimal('qst',8,2)->default('0');
            $table->decimal('pst',8,2)->default('0'); 
            $table->decimal('hst',8,2)->default('0');
            $table->decimal('total_taxes',8,2)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('gst');
            $table->dropColumn('rst');
            $table->dropColumn('qst');
            $table->dropColumn('pst'); 
            $table->dropColumn('hst');
            $table->dropColumn('total_taxes');
        });
    }
}
