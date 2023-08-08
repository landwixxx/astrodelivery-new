<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'order_item_id',
        'additional_id',
        'quantidade',
        'valor_adicional_pedido',
        'store_id',
    ];

    protected $dates = ['deleted_at'];

    public function additional()
    {
        return $this->belongsTo(Product::class, 'additional_id', 'id');
    }

    public function order_item()
    {
        return $this->belongsTo(OrderItems::class, 'order_item_id', 'id');
    }
}
