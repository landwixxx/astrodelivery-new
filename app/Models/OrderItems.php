<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantidade',
        'valor_item_pedido',
        'obs_produto',
        'store_id',
    ];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Retorna todos os adicionais do pedidos deste item
     *
     * @return void
     */
    public function additional_items()
    {
        return AdditionalItems::where('order_id', $this->order_id)->where('order_item_id', $this->id);
    }
}
