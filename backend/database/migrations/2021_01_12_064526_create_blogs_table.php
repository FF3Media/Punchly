<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(1);
            $table->string('blog_title');
            $table->string('blog_slug')->unique();
            $table->text('blog_description')->nullable();
            $table->string('feature_image')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->smallInteger('blog_category_id')->default(0); 
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
        Schema::dropIfExists('blogs');
    }
}
