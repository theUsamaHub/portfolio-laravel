<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'project_category_id', 'name', 'slug', 'description', 'short_description',
        'content', 'thumbnail', 'status', 'client_name', 'project_url',
        'github_url', 'start_date', 'end_date', 'is_featured', 'sort_order',
        'views_count', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function technologies()
    {
        return $this->hasMany(ProjectTechnology::class)->orderBy('sort_order');
    }

    public function gallery()
    {
        return $this->hasMany(ProjectGallery::class)->orderBy('sort_order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
