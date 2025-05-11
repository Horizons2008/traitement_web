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
        Schema::table('fonctions', function (Blueprint $table) {
            // Drop the unique constraint if it exists
            $table->dropUnique('fonctions_groupe_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonctions', function (Blueprint $table) {
            // Add back the unique constraint if needed to rollback
            $table->unique('groupe_id', 'fonctions_groupe_id_unique');
        });
    }
};
