<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHours extends Model
{
    use HasFactory;

    protected $fillable = ['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom', 'store_id'];
}
