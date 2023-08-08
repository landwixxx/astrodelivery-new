<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopkeeperToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'lojista_id',
    ];

    public function lojista()
    {
        return $this->belongsTo(User::class, 'lojista_id');
    }
}
