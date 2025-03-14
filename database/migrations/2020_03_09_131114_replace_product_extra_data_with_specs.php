<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplaceProductExtraDataWithSpecs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('specs')->nullable();
            $table->string('category')->nullable();
        });

        // Verificar si las columnas existen antes de eliminarlas
        $columnsToDrop = [
            'product_category_id',
            'back_brake_id',
            'back_tire_id',
            'front_brake_id',
            'front_tire_id',
            'product_engine_id',
            'fuel_capacity',
            'weight',
            'datasheet_image',
        ];

        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('products', $column)) {
                Schema::table('products', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        // Verificar si las tablas existen antes de eliminarlas
        $tablesToDrop = ['product_categories', 'product_brakes', 'product_engines', 'product_tires'];

        foreach ($tablesToDrop as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['specs', 'category']);

            $table->integer('product_category_id')->nullable();
            $table->integer('back_brake_id')->nullable();
            $table->integer('back_tire_id')->nullable();
            $table->integer('front_brake_id')->nullable();
            $table->integer('front_tire_id')->nullable();
            $table->integer('product_engine_id')->nullable();
            $table->string('fuel_capacity')->nullable();
            $table->string('weight')->nullable();
            $table->string('datasheet_image')->nullable();
            $table->string('description_image_1')->nullable();
            $table->string('description_image_2')->nullable();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('product_engines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('product_brakes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('product_tires', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
    }
}
