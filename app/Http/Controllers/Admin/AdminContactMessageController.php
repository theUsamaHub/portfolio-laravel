<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhere('subject', 'ilike', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'unread') {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'status' => 'in:unread,read,replied,archived,spam',
            'notes' => 'nullable|string|max:5000',
            'admin_reply' => 'nullable|string|max:5000',
        ]);

        $message->update($validated);

        if (isset($validated['admin_reply']) && $validated['admin_reply']) {
            $message->reply($validated['admin_reply']);
        }

        return back()->with('success', 'Message updated successfully.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }

    public function markUnread(ContactMessage $message)
    {
        $message->update(['status' => 'unread']);
        return back()->with('success', 'Marked as unread.');
    }
}
