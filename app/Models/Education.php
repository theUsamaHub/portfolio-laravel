<?php

namespace App\Models;

use App\Models\BaseModel;

class Education extends BaseModel
{
    protected $table = 'educations';

    protected $fillable = ['institution', 'degree', 'field_of_study', 'description', 'institution_logo', 'start_date', 'end_date', 'grade', 'activities', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
