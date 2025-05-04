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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
    $table->decimal('point_cat', 8, 2)->comment('Point value based on category');
    $table->decimal('mont_cat', 10, 2)->comment('point_cat * 45');
    $table->decimal('point_echelon', 8, 2)->comment('Point value based on echelon');
    $table->decimal('mont_echelon', 10, 2)->comment('point_echelon * 45');
    $table->decimal('sal_base', 10, 2)->comment('mont_cat + mont_echelon');
    $table->json('prime_details')->nullable()->comment('Array of prime calculations');
    $table->decimal('total_primes', 10, 2)->comment('Sum of all mont_prime values');
    $table->decimal('sal_brut', 10, 2)->comment('sal_base + total_primes');
    $table->decimal('assurance', 10, 2)->comment('sal_brut * 0.09');
    $table->decimal('net_salary', 10, 2)->comment('sal_brut - assurance');
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
        Schema::dropIfExists('salaries');
    }
};
