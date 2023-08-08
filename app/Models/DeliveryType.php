<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'tipo',
        'icone',
        'classe',
        'valor',
        'valor_minimo',
        'tempo',
        'ativo',
        'param',
        'bloqueia_sem_cep',
        'store_id',
    ];

    public function delivery_type_has_payment_methods()
    {
        return $this->hasMany(DeliveryTypeHasPaymentMethod::class);
    }

    public function delivery_zip_codes()
    {
        return $this->hasMany(DeliveryZipCode::class, 'tipo_entrega_id');
    }

    public function delivery_tables()
    {
        return $this->hasMany(DeliveryTable::class, 'tipo_entrega_id');
    }
}
