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
        Schema::table('expenses', function (Blueprint $table) {
            // Drop foreign key constraint if it exists
            $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('expenses');
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('group_id', $foreignKey->getLocalColumns())) {
                    $table->dropForeign($foreignKey->getName());
                }
            }
            $table->unsignedBigInteger('group_id')->nullable()->change();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }
};
