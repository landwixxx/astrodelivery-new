<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MontarPizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'store_id'
    ];
}
