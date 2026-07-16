<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address', 'user_agent', 'referrer', 'notes', 'admin_reply', 'replied_at'];

    protected function casts(): array
    {
        return ['replied_at' => 'datetime'];
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    public function markAsRead(): bool
    {
        return $this->update(['status' => 'read']);
    }

    public function archive(): bool
    {
        return $this->update(['status' => 'archived']);
    }

    public function reply(string $reply): bool
    {
        return $this->update(['admin_reply' => $reply, 'status' => 'replied', 'replied_at' => now()]);
    }
}
