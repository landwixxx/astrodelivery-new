<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryZipCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_zip_codes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->string('nome');
            $table->string('cep_ini');
            $table->string('cep_fim');
            $table->decimal('valor', 12, 2);
            $table->string('usu_alt')->nullable();
            $table->enum('status', ['ativo', 'desativado']);
            $table->foreignId('tipo_entrega_id')->constrained('delivery_types')->cascadeOnDelete();
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
        Schema::dropIfExists('delivery_zip_codes');
    }
}
