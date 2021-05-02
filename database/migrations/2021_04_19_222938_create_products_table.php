<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_products', function (Blueprint $table) {
            $table->id()->from(100000);
            $table->string('financial_institutions_id')->references('id')->on('financial_institutions');
            $table->string('description');
            $table->decimal('minimum_value',15,2);
            $table->decimal('administration_fee',4,2);
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
        Schema::dropIfExists('financial_products');
    }
}
