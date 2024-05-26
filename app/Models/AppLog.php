<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'model_id',
        'operation',
        'data',
        'ip_address',
        'username',
    ];
}
