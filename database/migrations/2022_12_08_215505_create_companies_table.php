<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->string('cnpj');
            $table->string('fantasia');
            $table->string('razao_social');
            $table->string('telefone');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('nome_contato')->nullable();
            $table->string('telefone_contato');
            $table->string('endereco');
            $table->string('numero_end');
            $table->string('ponto_referencia')->nullable();
            $table->string('complemento')->nullable();
            $table->string('uf');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('cep');
            $table->string('cor')->nullable();
            $table->enum('ativo', ['S', 'N'])->nullable()->default('S');
            $table->text('sobre')->nullable();

            $table->string('cnae')->nullable();
            $table->string('insc_estadual')->nullable();
            $table->string('insc_estadual_subs')->nullable();
            $table->string('insc_municipal')->nullable();
            $table->string('cod_ibge')->nullable();
            $table->enum('regime_tributario', ['simples_nacional', 'lucro_presumido', 'lucro_real'])->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('companies');
    }
}
