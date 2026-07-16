<?php

namespace App\Models;

use App\Models\BaseModel;

class ProjectTechnology extends BaseModel
{
    protected $fillable = ['project_id', 'name', 'icon', 'color', 'url', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
