<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryStateCityPostcodeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {             
            $table->string('country')->nullable()->after('mobile');
            $table->string('state')->nullable()->after('mobile');
            $table->string('city')->nullable()->after('mobile');
            $table->string('postcode')->nullable()->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('countries');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('postcode');
        });
    }
}
