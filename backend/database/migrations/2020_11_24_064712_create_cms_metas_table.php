<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_metas', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->mediumInteger('user_id')->nullable();
            $table->string('slug',15)->nullable();
            $table->string('meta_key')->nullable();
            $table->longText('meta_value')->nullable();
            $table->unsignedBigInteger('cms_id');
            $table->foreign('cms_id')
            ->references('id')->on('cms')
            ->onDelete('cascade');
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
        Schema::dropIfExists('cms_metas');
    }
}
