<?php

namespace App\Models;

use App\Models\BaseModel;

class Backup extends BaseModel
{
    protected $fillable = ['filename', 'disk', 'size', 'status', 'type'];

    protected function casts(): array
    {
        return ['size' => 'integer'];
    }
}
