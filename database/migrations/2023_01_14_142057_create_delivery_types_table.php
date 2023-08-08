<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_types', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique()->nullable();
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['Balcão', 'Delivery', 'Mesa', 'Correios']);
            $table->string('icone'); // ícone do fontawesome, ex: fas fa-car-side
            $table->enum('classe', ['secondary', 'primary', 'danger', 'warning', 'dark']);
            $table->decimal('valor', 12, 2);
            $table->decimal('valor_minimo', 12, 2);
            $table->string('tempo')->nullable();
            $table->string('param')->nullable();
            $table->enum('ativo', ['S', 'N']);
            $table->enum('bloqueia_sem_cep', ['S', 'N']);
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
        Schema::dropIfExists('delivery_types');
    }
}
