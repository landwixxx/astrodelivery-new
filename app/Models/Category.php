<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'foto',
        'nome',
        'descricao',
        'slug',
        'ativo',
        'usu_alt',
        'ordem',
        'ordem_produtos',
        'store_id',
    ];

    protected $appends = ['dta_alteracao'];

    public function getDtaAlteracaoAttribute()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function produtos_categoria(){
        return $this->hasMany('App\Models\Product')
        ->select(DB::raw('id, nome, descricao, valor, tipo, estoque'))

        ->orderBy('id', 'asc');
    }
}
