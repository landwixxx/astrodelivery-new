<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'foto',
        'descricao',
        'principal',
        'extensao',
        'mimetype',
        'product_id',
        'store_id',
    ];
    protected $dates = ['deleted_at'];
}
