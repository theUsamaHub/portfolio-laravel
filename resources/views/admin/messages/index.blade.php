@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div><h2 style="font-size: 1.25rem; font-weight: 700;">Contact Messages</h2></div>
    <form method="GET" class="flex gap-2">
        <input type="text" class="form-input" name="search" placeholder="Search..." value="{{ request('search') }}" style="max-width: 200px;">
        <button class="btn btn-primary btn-sm">Search</button>
    </form>
</div>
<div class="flex gap-2 mb-4">
    <a href="{{ route('admin.messages.index', ['status' => 'all']) }}" class="filter-btn {{ request('status', 'all') === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="filter-btn {{ request('status') === 'unread' ? 'active' : '' }}">Unread</a>
    <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="filter-btn {{ request('status') === 'replied' ? 'active' : '' }}">Replied</a>
    <a href="{{ route('admin.messages.index', ['status' => 'archived']) }}" class="filter-btn {{ request('status') === 'archived' ? 'active' : '' }}">Archived</a>
</div>
<div class="card">
    <table class="admin-table">
        <thead><tr><th>From</th><th>Subject</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($messages as $msg)
                <tr style="{{ $msg->status === 'unread' ? 'font-weight: 600;' : '' }}">
                    <td>{{ $msg->name }}<br><small class="text-muted">{{ $msg->email }}</small></td>
                    <td>{{ Str::limit($msg->subject, 40) }}</td>
                    <td><span class="badge badge-sm {{ match($msg->status) { 'unread' => 'badge-danger', 'replied' => 'badge-success', 'archived' => 'badge-info', default => 'badge-warning' } }}">{{ ucfirst($msg->status) }}</span></td>
                    <td class="text-muted">{{ $msg->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-ghost btn-sm">View</a>
                            @if($msg->status !== 'unread')
                                <form method="POST" action="{{ route('admin.messages.mark-unread', $msg) }}" style="display:inline;">@csrf<button class="btn btn-ghost btn-sm">Unread</button></form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; padding: 3rem;"><p class="text-muted">No messages found.</p></td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 1rem;">{{ $messages->withQueryString()->links() }}</div>
</div>
@endsection
