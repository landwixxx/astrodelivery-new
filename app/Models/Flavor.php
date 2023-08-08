<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    use HasFactory;

    protected $fillable = [
        'sabor',
        'descricao',
        'valor',
        'store_id',
        'img'
    ];
}
