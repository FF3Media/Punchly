<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(1);
            $table->string('service_title');
            $table->string('service_slug')->unique();
            $table->text('service_description')->nullable();
            $table->string('feature_image')->nullable();
            $table->unsignedBigInteger('created_by')->default(0); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_services');
    }
}
