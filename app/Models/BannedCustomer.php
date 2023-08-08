<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id'
    ];
}
