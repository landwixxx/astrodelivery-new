<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable()->unique();
            $table->longText('foto')->nullable();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('slug');
            $table->enum('ativo', ['S', 'N']);
            $table->string('usu_alt')->nullable();
            $table->string('ordem')->nullable();
            $table->string('ordem_produtos')->nullable();

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
        Schema::dropIfExists('categories');
    }
}
