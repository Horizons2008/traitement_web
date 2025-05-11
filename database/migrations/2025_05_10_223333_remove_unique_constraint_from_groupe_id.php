<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            // First drop the foreign key constraint
            $table->dropForeign(['groupe_id']);
            
            // Then drop the unique constraint
            $table->dropUnique('fonctions_groupe_id_unique');
            
            // Finally, recreate the foreign key constraint without the unique constraint
            $table->foreign('groupe_id')
                  ->references('id')
                  ->on('groupes')
                  ->onDelete('set null');
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
            // Drop the foreign key
            $table->dropForeign(['groupe_id']);
            
            // Add back the unique constraint
            $table->unique('groupe_id', 'fonctions_groupe_id_unique');
            
            // Recreate the foreign key
            $table->foreign('groupe_id')
                  ->references('id')
                  ->on('groupes')
                  ->onDelete('set null');
        });
    }
};
