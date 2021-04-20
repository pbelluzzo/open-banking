<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituicao_financeira', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->primary();
            $table->string('razao_social')->unique();
            $table->string('nome_fantasia');
            $table->string('cod_bancario');
            $table->string('caminho_logo');
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
        Schema::dropIfExists('instituicao_financeira');
    }
}
