<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaAdditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_id',
    ];

    public function adicional()
    {
        return $this->belongsTo(Product::class, 'product_id')->whereNull('deleted_at');
    }
}
