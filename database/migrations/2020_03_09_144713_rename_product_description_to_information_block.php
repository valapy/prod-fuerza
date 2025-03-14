<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProductDescriptionToInformationBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_descriptions', function (Blueprint $table) {
            $table->text('data')->default('{}');
            $table->string('source');
            $table->string('template');
            $table->renameColumn('product_id', 'source_id');
            $table->dropColumn('description');
        });

        Schema::rename('product_descriptions', 'information_blocks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('information_blocks', function (Blueprint $table) {
            $table->dropColumn(['data', 'source', 'template']);
            $table->renameColumn('source_id', 'product_id');
        });

        Schema::rename('information_blocks', 'product_descriptions');
    }
}
