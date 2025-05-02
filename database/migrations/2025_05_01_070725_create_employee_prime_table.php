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
        Schema::create('employee_prime', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('employee_id');
    $table->unsignedBigInteger('prime_id');
    $table->integer('type')->default(0)->comment('Type of prime assignment');
            $table->integer('valeur')->default(0)->comment('Value/amount of the prime');
    $table->timestamps();

    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    $table->foreign('prime_id')->references('id')->on('primes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_prime');
    }
};
