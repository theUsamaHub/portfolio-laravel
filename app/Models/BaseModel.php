<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    public static function tableExists(): bool
    {
        return Schema::hasTable((new static)->getTable());
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
