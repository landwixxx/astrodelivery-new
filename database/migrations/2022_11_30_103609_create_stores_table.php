<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug_url');
            $table->string('logo')->nullable();
            $table->string('banner_promocional')->nullable();
            $table->string('imagem_bg')->nullable();
            $table->longText('descricao');
            $table->string('email');
            $table->string('telefone');
            $table->string('whatsapp');

            $table->string('rua');
            $table->string('numero_end');
            $table->string('ponto_referencia')->nullable();
            $table->string('complemento')->nullable();
            $table->string('uf');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('cep');

            $table->string('url_facebook')->nullable();
            $table->string('url_twitter')->nullable();
            $table->string('url_instagram')->nullable();
            $table->enum('empresa_aberta', ['sim', 'nao'])->default('sim');

            $table->unsignedBigInteger('lojista_id');
            $table->foreign('lojista_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('stores');
    }
}
