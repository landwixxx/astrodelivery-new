<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'tipo',
        'icone',
        'classe',
        'ativo',
        'param',
        'store_id',
        'usu_alt',
    ];

    protected $appends = ['dta_alteracao'];

    public function getDtaAlteracaoAttribute()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }
}
