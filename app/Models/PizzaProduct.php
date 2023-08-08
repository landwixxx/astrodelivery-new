<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'valor_minimo',
        'qtd_min_sabores',
        'qtd_max_sabores',
        'sabores',
        'bordas',
    ];

    protected $casts = [
        'sabores' => 'array',
        'bordas' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
