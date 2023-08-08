<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'adicional_qtd_min',
        'adicional_qtd_max',
        'adicional_juncao',
        'ordem',
        'ordem_interna',
        'store_id',
    ];
}
