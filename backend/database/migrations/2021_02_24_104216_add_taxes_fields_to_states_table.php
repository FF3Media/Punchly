<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxesFieldsToStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {          
           $table->set('type', ['GST', 'RST','QST','PST','HST'])->nullable()->after('country_id');
           $table->decimal('GST', $precision = 8, $scale = 2)->default(0)->after('type');
           $table->decimal('RST', $precision = 8, $scale = 2)->default(0)->after('GST');
           $table->decimal('QST', $precision = 8, $scale = 2)->default(0)->after('RST');
           $table->decimal('PST', $precision = 8, $scale = 2)->default(0)->after('QST');
           $table->decimal('HST', $precision = 8, $scale = 3)->default(0)->after('PST'); 
           $table->integer('total_tax_rate')->default(0)->after('HST');  

           
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function (Blueprint $table) {
              $table->dropColumn('type');
              $table->dropColumn('GST');
              $table->dropColumn('RST');
              $table->dropColumn('QST');
              $table->dropColumn('PST');
              $table->dropColumn('HST');
              $table->dropColumn('total_tax_rate');
        });
    }
}
