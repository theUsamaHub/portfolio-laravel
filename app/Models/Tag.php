<?php

namespace App\Models;

use App\Models\BaseModel;

class Tag extends BaseModel
{
    protected $fillable = ['name', 'slug'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tag');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
