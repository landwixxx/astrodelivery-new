<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_groups', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->integer('adicional_qtd_min')->nullable();
            $table->integer('adicional_qtd_max')->nullable();
            $table->enum('adicional_juncao', ['SOMA', 'DIVIDIR', 'MEDIA'])->nullable();
            $table->integer('ordem')->default(1);
            $table->string('ordem_interna')->nullable(); // VLR_DECR|NOME_CRES...
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('additional_groups');
    }
}
