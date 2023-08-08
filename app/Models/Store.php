<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug_url',
        'logo',
        'banner_promocional',
        'imagem_bg',
        'descricao',
        'email',
        'telefone',
        'whatsapp',

        'rua',
        'numero_end',
        'ponto_referencia',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',

        'url_facebook',
        'url_twitter',
        'url_instagram',
        'empresa_aberta',
        'lojista_id'
    ];

    public function store_has_customers()
    {
        return $this->hasMany(StoreHasCustomer::class);
    }

    public function user_shopkeeper()
    {
        return $this->belongsTo(User::class, 'lojista_id');
    }

    public function opening_hours()
    {
        return $this->hasOne(OpeningHours::class);
    }

    public function store_has_user()
    {
        return $this->hasOne(StoreHasUsers::class);
    }

    public function products()
    {
        return $this->hasOne(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function promotional_banners()
    {
        return $this->hasMany(PromotionalBanner::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
