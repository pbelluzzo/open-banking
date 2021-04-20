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
        Schema::create('produtos_financeiros', function (Blueprint $table) {
            $table->id()->from(100000);
            $table->string('cnpj_instituicao')->references('id')->on('instituicao_financeira');
            $table->string('descricao');
            $table->decimal('valor_minimo',15,2);
            $table->decimal('taxa_de_administracao',4,2);
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
        Schema::dropIfExists('produtos_financeiros');
    }
}
