<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->charset = "utf8";
            $table->collation = "utf8_general_ci";

            $table->increments('id');
            $table->string('model');
            $table->integer('product_category_id');
            $table->integer('product_engine_id');
            $table->integer('front_brake_id');
            $table->integer('back_brake_id');
            $table->integer('front_tire_id');
            $table->integer('back_tire_id');
            $table->string('fuel_capacity');
            $table->string('weight');
            $table->string('intro');
            $table->string('video')->nullable();
            $table->text('description');

            $table->string('header_image')->nullable();
            $table->string('header_image_mobile')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_logo')->nullable();
            $table->string('description_image_1')->nullable();
            $table->string('description_image_2')->nullable();

            $table->string('pdf')->nullable();

            $table->integer('order')->default(0);

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
        Schema::dropIfExists('products');
    }
}
