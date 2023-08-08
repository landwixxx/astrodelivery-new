<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('delivery_type_id')->nullable()->constrained()->nullOnDelete();
            $table->time('tempo')->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('delivery_table_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('situacao_pgto', ['PENDENTE', 'PAGO'])->default('PENDENTE');
            $table->decimal('valor', 12, 2)->nullable();
            $table->integer('order_status_id')->constrained('order_status')->cascadeOnDelete()->default(1);
            $table->longText('obs_status_pedido')->nullable();
            $table->text('observacao')->nullable();
            $table->integer('qtd_itens')->nullable();
            $table->decimal('valor_troco', 12, 2)->nullable();
            $table->decimal('total_pedido', 12, 2)->nullable();
            $table->json('end_entrega')->nullable();
            $table->json('data_order')->nullable(); // será armazenados os produtos que estão na session do carrinho, para depois repetir o pedido
            $table->json('data_montar_pizza')->nullable(); // será armazenados os dados de montar pizza caso seja um pedido q tenha montar pizza
            $table->json('data_pizza_produto')->nullable(); // será armazenados os dados de pizza produto caso seja um pedido
            $table->string('timestamp_aceito')->nullable(); // timestamp que foi aceio o pedido
            $table->enum('integrado', ['S', 'N'])->default('N');
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('orders');
    }
}
