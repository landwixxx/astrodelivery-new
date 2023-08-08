<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{
    use HasFactory;

    protected $fillable = [
        'borda',
        'descricao',
        'valor',
        'img',
        'store_id',
    ];
}
