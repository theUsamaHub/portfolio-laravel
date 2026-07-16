@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 style="font-size: 1.25rem; font-weight: 700;">Message from {{ $message->name }}</h2>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-ghost btn-sm">Back to Messages</a>
</div>
<div class="grid grid-3 gap-6">
    <div class="col-span-2">
        <div class="card mb-6">
            <h3 style="font-weight: 600; margin-bottom: 1rem;">Message</h3>
            <div class="form-group"><label class="form-label">From</label><p>{{ $message->name }} &lt;{{ $message->email }}&gt;</p></div>
            <div class="form-group"><label class="form-label">Phone</label><p>{{ $message->phone ?? 'Not provided' }}</p></div>
            <div class="form-group"><label class="form-label">Subject</label><p>{{ $message->subject }}</p></div>
            <div class="form-group"><label class="form-label">Message</label><div style="background: var(--bg-secondary); padding: 1rem; border-radius: var(--radius); white-space: pre-wrap;">{{ $message->message }}</div></div>
            <div class="form-group"><label class="form-label">Received</label><p class="text-muted">{{ $message->created_at->format('M d, Y h:i A') }}</p></div>
        </div>
        @if($message->admin_reply)
            <div class="card mb-6" style="border-color: var(--color-success);">
                <h3 style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-success);">Your Reply</h3>
                <p>{{ $message->admin_reply }}</p>
                <small class="text-muted">Replied {{ $message->replied_at?->diffForHumans() }}</small>
            </div>
        @endif
    </div>
    <div>
        <div class="card mb-6">
            <h3 style="font-weight: 600; margin-bottom: 1rem;">Actions</h3>
            <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        @foreach(['unread','read','replied','archived','spam'] as $s)
                            <option value="{{ $s }}" {{ $message->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Admin Reply</label>
                    <textarea class="form-textarea" name="admin_reply" rows="5" placeholder="Type your reply...">{{ old('admin_reply', $message->admin_reply ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-textarea" name="notes" rows="3" placeholder="Internal notes...">{{ old('notes', $message->notes ?? '') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-full">Update</button>
            </form>
        </div>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger w-full">Delete Message</button>
        </form>
    </div>
</div>
@endsection
