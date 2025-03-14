<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToHomeCarousel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_carousel', function (Blueprint $table) {
            $table->string('type')->default('image');
            $table->renameColumn('image', 'media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_carousel', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->renameColumn('media', 'image');
        });
    }
}
