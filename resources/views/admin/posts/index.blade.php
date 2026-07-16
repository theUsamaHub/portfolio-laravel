@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div><h2 style="font-size: 1.25rem; font-weight: 700;">Blog Posts</h2></div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
</div>
<div class="flex gap-2 mb-4">
    <a href="{{ route('admin.posts.index', ['status' => 'all']) }}" class="filter-btn {{ request('status', 'all') === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="filter-btn {{ request('status') === 'published' ? 'active' : '' }}">Published</a>
    <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="filter-btn {{ request('status') === 'draft' ? 'active' : '' }}">Draft</a>
</div>
<div class="card">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td class="font-semibold">{{ $post->name }}</td>
                    <td>{{ $post->category?->name ?? '-' }}</td>
                    <td><span class="badge badge-sm {{ $post->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($post->status) }}</span></td>
                    <td class="text-muted">{{ $post->published_at?->format('M d, Y') ?? '-' }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-ghost btn-sm" style="color: var(--color-danger);">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; padding: 3rem;">
                    <div class="empty-state"><div class="empty-state-title">No Posts Yet</div><p class="empty-state-description">Create your first blog post.</p><a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create Post</a></div>
                </td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 1rem;">{{ $posts->withQueryString()->links() }}</div>
</div>
@endsection
