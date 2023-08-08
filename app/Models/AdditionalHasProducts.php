<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalHasProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'additional_product_id',
        'store_id',
    ];

    public function additional_product()
    {
        return $this->belongsTo(Product::class, 'id', 'additional_product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}