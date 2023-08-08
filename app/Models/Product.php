<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'tipo',
        'category_id',
        'nome',
        'sub_nome',
        'cor_sub_nome',
        'descricao',
        'grupo_adicional_id',
        'codigo_empresa',
        'codigo_barras',
        'codigo_barras_padrao',
        'valor_original',
        'valor',
        'estoque',
        'limitar_estoque',
        'fracao',
        'item_adicional',
        'item_adicional_obrigar',
        'item_adicional_multi',
        'adicional_qtde_min',
        'adicional_qtde_max',
        'adicional_juncao',
        'ativo',
        'ordem',
        'usu_alt',
        'store_id',
    ];

    protected $appends = [
        'img_destaque'
    ];

    protected $dates = ['deleted_at'];

    public function getImgDestaqueAttribute()
    {
        $image = $this->image()->where('principal', 'S')->first();
        $result = null;
        if (!is_null($image)) :
            $result = $image->foto;
        else :
            $result = asset('assets/img/img-prod-vazio.png');
        endif;

        return $result;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function additional_group()
    {
        return $this->hasOne(AdditionalGroup::class, 'id', 'grupo_adicional_id');
    }

    public function additional_has_products()
    {
        return $this->hasMany(AdditionalHasProducts::class);
    }

    public function pizza_product()
    {
        return $this->hasOne(PizzaProduct::class);
    }
}
