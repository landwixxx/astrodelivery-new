<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTypeHasPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_type_id',
        'payment_method_id'
    ];

    public function delivery_type()
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
