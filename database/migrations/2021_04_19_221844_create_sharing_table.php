<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharings', function (Blueprint $table) {
            $table->id();
            $table->string('clients_id')->references('id')->on('clients');
            $table->string('origin_institution_id')->references('id')->on('financial_institutions');
            $table->string('destiny_institution_id')->references('id')->on('financial_institutions');
            $table->date('acceptance_date')->nullable();
            $table->string('xml_path')->nullable();
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
        Schema::dropIfExists('sharings');
    }
}
