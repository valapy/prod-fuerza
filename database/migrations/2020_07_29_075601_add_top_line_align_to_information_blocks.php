<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopLineAlignToInformationBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('information_blocks', function (Blueprint $table) {
            $table->text('top_line_alignment', 6)->default('left');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('information_blocks', function (Blueprint $table) {
            $table->dropColumn(['top_line_alignment']);
        });
    }
}
