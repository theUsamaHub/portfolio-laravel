<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;

class ContactService
{
    public function store(array $data): ContactMessage
    {
        $message = ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
        ]);

        Log::info('New contact message received', ['id' => $message->id, 'from' => $message->email]);

        return $message;
    }

    public function getStats(): array
    {
        return [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read' => ContactMessage::read()->count(),
            'replied' => ContactMessage::replied()->count(),
            'archived' => ContactMessage::archived()->count(),
            'spam' => ContactMessage::spam()->count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
        ];
    }
}
