@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700;">Projects</h2>
        <p class="text-muted">Manage your portfolio projects</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ New Project</a>
</div>

{{-- Filters --}}
<div class="flex gap-2 mb-4">
    <a href="{{ route('admin.projects.index', ['status' => 'all']) }}" class="filter-btn {{ request('status', 'all') === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.projects.index', ['status' => 'published']) }}" class="filter-btn {{ request('status') === 'published' ? 'active' : '' }}">Published</a>
    <a href="{{ route('admin.projects.index', ['status' => 'draft']) }}" class="filter-btn {{ request('status') === 'draft' ? 'active' : '' }}">Draft</a>
</div>

{{-- Projects Table --}}
<div class="card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td class="font-semibold">{{ $project->name }}</td>
                        <td>{{ $project->category?->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-sm {{ $project->status === 'published' ? 'badge-success' : ($project->status === 'draft' ? 'badge-warning' : 'badge-info') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>{{ $project->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="text-muted">{{ $project->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-ghost btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-ghost btn-sm" style="color: var(--color-danger);">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem;">
                            <div class="empty-state">
                                <div class="empty-state-icon">&#128194;</div>
                                <p class="empty-state-title">No Projects Yet</p>
                                <p class="empty-state-description">Create your first project to get started.</p>
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Create Project</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem;">{{ $projects->withQueryString()->links() }}</div>
</div>
@endsection
