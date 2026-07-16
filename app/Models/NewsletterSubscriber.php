<?php

namespace App\Models;

use App\Models\BaseModel;

class NewsletterSubscriber extends BaseModel
{
    protected $fillable = ['email', 'name', 'is_active', 'subscribed_at', 'unsubscribed_at'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function unsubscribe(): bool
    {
        return $this->update(['is_active' => false, 'unsubscribed_at' => now()]);
    }
}
