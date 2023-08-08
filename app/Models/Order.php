<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'delivery_type_id',
        'user_id',
        'taxa_entrega',
        'entrega',
        'valor_troco',
        'estado',
        'pagamento',
        'observacao',
        'status',
        'store_id',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'cep',
        'complemento',
        'valor',
        'tempo',
        'payment_method_id',
        'qtd_itens',
        'total_pedido',
        'data_order',
        'data_montar_pizza',
        'data_pizza_produto',
        'timestamp_aceito',
        'delivery_table_id',
        'order_status_id',
        'integrado', // S/N
        'obs_status_pedido'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'end_entrega' => 'array',
        'data_order' => 'array',
        'data_montar_pizza' => 'array',
        'data_pizza_produto' => 'array',
    ];

    public function order_items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function additional_items()
    {
        return $this->hasMany(AdditionalItems::class);
    }

    public function order_status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }

    public function delivery()
    {
        return $this->hasOne(DeliveryType::class, 'id', 'delivery_type_id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function delivery_table()
    {
        return $this->belongsTo(DeliveryTable::class);
    }
}
