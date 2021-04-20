<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_conta')->references('id')->on('contas');
            $table->integer('id_produto')->references('id')->on('produtos_financeiros');
            $table->decimal('valor_investido',15,2);
            $table->decimal('taxa_de_administracao',4,2);
            $table->date('data_de_contratacao');
            $table->boolean('finalizado');
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
        Schema::dropIfExists('contratos');
    }
}
