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
      
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('nomAr');
                $table->string('prenAr');
                $table->string('nomFr');
                $table->string('prenFr');
                $table->string('mobile');
                $table->date('ddn')->nullable();
                $table->string('ldn');
                $table->tinyInteger('sit_famill')->default(0); // 0=single, 1=marriedFoyer, 2=marriedNonFoyer
                $table->integer('nbrEnfant')->default(0);
                $table->integer('Plus10')->default(0);
                $table->boolean('endicape')->default(false);
                $table->string('ccp');
                $table->date('dateRecrut');
                $table->date('lastGraduation');
                $table->integer('cat');
                $table->integer('echelon');
                $table->integer('nbrAnneeExperience');
                $table->unsignedBigInteger('fonction_id');
                $table->unsignedBigInteger('groupe_id');
                $table->timestamps();
            
                $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('cascade');
                $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
