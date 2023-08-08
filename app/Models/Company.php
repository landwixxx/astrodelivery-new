<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'cnpj',
        'fantasia',
        'razao_social',
        'telefone',
        'whatsapp',
        'email',
        'nome_contato',
        'telefone_contato',
        'endereco',
        'numero_end',
        'ponto_referencia',
        'complemento',
        'uf',
        'cidade',
        'bairro',
        'cep',
        'sobre',
        'cor',
        'ativo', // S/N
        'cnae',
        'insc_estadual',
        'insc_estadual_subs',
        'insc_municipal',
        'cod_ibge',
        'regime_tributario',
        'user_id'
    ];
}
