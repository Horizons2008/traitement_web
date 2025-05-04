<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::table('primes', function (Blueprint $table) {
                $table->integer('mode')->default(0)->after('max_cat');
                $table->integer('value')->default(0)->after('mode');
            });
            //
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('primes', function (Blueprint $table) {
            //
        });
    }
};
