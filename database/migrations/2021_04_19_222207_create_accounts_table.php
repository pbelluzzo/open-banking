<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_cliente')->references('cpf')->on('clientes');
            $table->string('cnpj_instituicao')->references('cnpj')->on('instituicao_financeira');
            $table->decimal('saldo',15,2);            
            $table->timestamps();
            $table->dateTime('encerrada_em')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas');
    }
}
