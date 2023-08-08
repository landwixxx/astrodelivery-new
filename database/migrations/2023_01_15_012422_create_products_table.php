<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->enum('tipo', ['PRODUTO', 'ADICIONAL', 'PIZZA']); // obrigatório
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->text('nome')->nullable();
            $table->text('sub_nome')->nullable();
            $table->string('cor_sub_nome')->nullable();
            $table->text('descricao')->nullable();

            $table->unsignedBigInteger('grupo_adicional_id')->nullable();
            $table->foreign('grupo_adicional_id')->references('id')->on('additional_groups')->onDelete('cascade');

            $table->string('codigo_empresa')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->string('codigo_barras_padrao')->nullable();
            $table->decimal('valor_original', 12, 2)->default(0.00)->nullable();
            $table->decimal('valor', 12, 2)->default(0.00)->nullable();
            $table->integer('estoque')->default(0)->nullable();
            $table->enum('limitar_estoque', ['S', 'N'])->nullable();
            $table->enum('fracao', ['S', 'N'])->default('N');
            $table->enum('item_adicional', ['S', 'N'])->nullable();
            $table->enum('item_adicional_obrigar', ['S', 'N'])->nullable();
            $table->enum('item_adicional_multi', ['S', 'N'])->nullable();
            $table->integer('adicional_qtde_min')->nullable()->nullable();
            $table->integer('adicional_qtde_max')->nullable()->nullable();
            $table->enum('adicional_juncao', ['SOMA', 'DIVIDIR', 'MEDIA'])->nullable();
            $table->enum('ativo', ['S', 'N'])->default('S');
            $table->string('ordem')->default(1);
            $table->string('usu_alt')->nullable();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete(); // obrigatório
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
