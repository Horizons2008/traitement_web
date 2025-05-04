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
        Schema::create('prime_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prime_id')->constrained()->cascadeOnDelete();
            $table->integer('min_cat')->nullable();
            $table->integer('max_cat')->nullable();
            $table->integer('valeur');
            $table->timestamps();
            
            // Composite unique constraint
            $table->unique(['prime_id', 'min_cat', 'max_cat'], 'prime_config_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prime_configurations');
    }
};
