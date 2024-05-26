<?php

namespace App\Models;

use App\Traits\GenerateAppLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, GenerateAppLog;

    protected $fillable = [
        "title",
        "sub_title",
        "icon",
        "sub_icon",
        "order",
        "sub_order",
        "route",
        "permissions",
        "is_active",
    ];

    public function scopeActive(Builder $builder): void
    {
        $builder->where('is_active', true);
    }

    public function scopeInactive(Builder $builder): void
    {
        $builder->where('is_active', false);
    }
}
