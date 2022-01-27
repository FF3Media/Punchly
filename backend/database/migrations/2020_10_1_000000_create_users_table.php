<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email',40)->unique();
            $table->boolean('status')->default(0);            
            $table->string('password',80)->nullable();
            $table->enum('user_role',['1','2','3','4'])->default('4')->comment('1 = Admin , 2 = Digitizer Manager , 3 = Digitizer , 4 = Embroiderer');
            $table->timestamps(); 
            $table->string('first_name',25)->nullable();
            $table->string('name',25)->nullable();
            $table->string('last_name',25)->nullable();            
            $table->string('avatar')->nullable();
            $table->string('provider', 20)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();
            $table->string('mobile',11)->nullable();                      
            $table->text('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();  
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
        Schema::dropIfExists('users');
    }
}
