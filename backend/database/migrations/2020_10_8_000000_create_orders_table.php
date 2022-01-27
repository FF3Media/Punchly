<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status',['1','2','3','4','5','6','7','8','9','10','11','12','13'])->default('1')->comment('1 = Pending acceptance , 2 = In process , 3 = Rejected , 4 = Completed , 5 = Added into cart , 6 = Refund succeeded , 7 =  Refund pending, 8 = Refund failed, 9 = Refund canceled, 10 = Work Submitted By Digitizer, 11 = Accept Submitted Work, 12 = Reject Submitted Work , 13 = Reworking');
            $table->string('order_name')->nullable();
            $table->longText('order_message')->nullable();
            $table->enum('measurement',['1', '2'])->default('1')->comment('1 = Inches , 2 = Centimeter');     
            $table->decimal('desired_height', $precision = 8, $scale = 2)->default('0');
            $table->decimal('desired_width', $precision = 8, $scale = 2)->default('0');
            $table->string('order_group_id')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('order_unique_id')->nullable();
            $table->integer('order_digitizer_id')->default(0);
            $table->foreignId('garment_id')->constrained('garments')->onDelete('cascade');
            $table->string('refund_id')->nullable();
            $table->integer('reason_id')->default(0);
            $table->string('desired_output')->nullable();
            $table->decimal('desired_old_height', $precision = 8, $scale = 2)->default(0);
            $table->decimal('desired_old_width', $precision = 8, $scale = 2)->default(0);
            $table->enum('manual_override',[0,1])->default(0)->comment('0 = Not Manual override , 1 = Manual override');
            $table->text('comment')->nullable();
            $table->string('reason_for_digitizer')->nullable();
            $table->decimal('amount', $precision = 8, $scale = 2)->default('0');
            $table->decimal('amount_after_coupon', $precision = 8, $scale = 2)->default('0');
            $table->timestamp('order_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string('feature_image')->nullable();          
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
        Schema::dropIfExists('orders');
    }
}
