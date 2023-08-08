<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZipCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'cep_ini',
        'cep_fim',
        'valor',
        'usu_alt',
        'status',
        'tipo_entrega_id',
        'store_id'
    ];

    public function delivery_type()
    {
        return $this->belongsTo(DeliveryType::class, 'tipo_entrega_id');
    }
}
