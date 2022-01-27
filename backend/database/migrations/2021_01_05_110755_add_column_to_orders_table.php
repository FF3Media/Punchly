<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('desired_old_height', $precision = 8, $scale = 2)->default(0);
            $table->decimal('desired_old_width', $precision = 8, $scale = 2)->default(0);
            $table->enum('manual_override',[0,1])->default(0)->comment('0 = Not Manual override , 1 = Manual override');
            $table->text('comment')->nullable();
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
        });
    }
}
