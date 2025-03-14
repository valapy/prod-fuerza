<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_requests', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->charset = "utf8";
            $table->collation = "utf8_general_ci";
            
            $table->increments('id');
            
            $table->string('name');
            $table->string('product_of_interest');
            $table->string('contact_method');
            $table->string('contact_value');
            $table->string('message');
            $table->integer('status')->default(1);

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
        Schema::dropIfExists('budget_requests');
    }
}
