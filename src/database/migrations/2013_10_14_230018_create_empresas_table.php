<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->nullable();
            $table->string('celular')->nullable();
            $table->string('fixo')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->default('RJ')->nullable();
            $table->string('pais')->default('Brasil')->nullable();

            $table->bigInteger('banco')->default('341')->nullable();
            $table->bigInteger('agencia')->default('0000')->nullable();
            $table->bigInteger('conta')->default('00000')->nullable();
            $table->bigInteger('digito')->default('00000')->nullable();
            $table->bigInteger('carteira')->default('00000')->nullable();
            $table->bigInteger('convenio')->default('0000000')->nullable();



            $table->string('db_host')->default('localhost')->nullable();
            $table->string('db_database')->nullable();
            $table->string('db_username')->default('root')->nullable();
            $table->string('db_password')->default('root')->nullable();
            
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
        Schema::dropIfExists('empresas');
    }
}
