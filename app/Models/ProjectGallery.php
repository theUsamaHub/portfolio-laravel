<?php

namespace App\Models;

use App\Models\BaseModel;

class ProjectGallery extends BaseModel
{
    protected $table = 'project_gallery';

    protected $fillable = ['project_id', 'image', 'caption', 'alt_text', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
