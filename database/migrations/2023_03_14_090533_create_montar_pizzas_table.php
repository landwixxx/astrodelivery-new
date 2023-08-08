<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMontarPizzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('montar_pizzas', function (Blueprint $table) {
            $table->id();
            // $table->string('titulo');
            // $table->longText('descricao')->nullable();
            $table->enum('status', ['ativo', 'desativado'])->default('desativado');
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
        Schema::dropIfExists('montar_pizzas');
    }
}
