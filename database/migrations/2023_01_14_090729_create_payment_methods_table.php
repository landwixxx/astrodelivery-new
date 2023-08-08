<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable()->unique();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['DINHEIRO', 'CARTAO', 'GATEWAY', 'OUTROS', 'BOLETO']);
            $table->string('icone'); // ícone do fontawesome, ex: fas fa-car-side
            $table->enum('classe', ['secondary', 'primary', 'danger', 'warning', 'dark', 'success']);
            $table->string('param')->nullable();
            $table->string('usu_alt')->nullable();
            $table->enum('ativo', ['S', 'N']);
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
        Schema::dropIfExists('payment_methods');
    }
}
