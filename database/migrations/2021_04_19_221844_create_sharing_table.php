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
        Schema::create('compartilhamentos', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_cliente')->references('cpf')->on('clientes');
            $table->string('cnpj_origem')->references('cnpj')->on('instituicao_financeira');
            $table->string('cnpj_destino')->references('cnpj')->on('instituicao_financeira');
            $table->date('data_do_aceite');
            $table->boolean('ainda_vigente');
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
        Schema::dropIfExists('compartilhamentos');
    }
}
