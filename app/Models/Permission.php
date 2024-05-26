<?php

namespace App\Models;

use App\Traits\GenerateAppLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory, GenerateAppLog;

    protected $fillable = [
        'name',
        'guard_name',
        'operation',
        'model',
        'is_crud',
        'is_active',
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
