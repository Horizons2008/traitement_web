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
       
            Schema::create('fonctions', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('abrv');
                $table->integer('cat');
                $table->timestamps();
                $table->unsignedBigInteger('groupe_id')->unique()->nullable();
        $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('set null');
            });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fonctions');
        Schema::table('fonctions', function (Blueprint $table) {
            $table->dropForeign(['groupe_id']);
            $table->dropColumn('groupe_id');
        });
    }
};
