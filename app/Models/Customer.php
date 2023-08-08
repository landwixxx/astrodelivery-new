<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'telefone',
        'whatsapp',
        'dt_nascimento',
        'endereco',
        'numero_end',
        'ponto_referencia',
        'complemento',
        'estado',
        'cidade',
        'bairro',
        'rua',
        'cep',
        'user_id'
    ];
}
