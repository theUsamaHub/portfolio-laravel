@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700;">Tags</h2>
        <p class="text-muted" style="font-size:0.875rem;">Manage tags for projects and blog posts</p>
    </div>
    <button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Tag</button>
</div>

<div class="card">
    <div class="card-body">
        @if($items->count())
            <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                @foreach($items as $tag)
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:var(--radius-full);font-size:0.9375rem;" id="tag-{{ $tag->id }}">
                        <span id="tag-label-{{ $tag->id }}">{{ $tag->name }}</span>
                        <span style="font-size:0.75rem;color:var(--text-muted);">({{ $tag->projects_count + $tag->posts_count }} uses)</span>
                        <button class="btn btn-ghost btn-sm" style="padding:0.125rem 0.375rem;font-size:0.75rem;" onclick="toggleTagEdit({{ $tag->id }})">Edit</button>
                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Delete this tag?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-ghost btn-sm" style="padding:0.125rem 0.375rem;font-size:0.75rem;color:var(--color-danger);">x</button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Inline Edit Forms --}}
            @foreach($items as $tag)
                <div id="tag-edit-{{ $tag->id }}" style="display:none;margin-top:1rem;padding:1rem;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:var(--radius);">
                    <form method="POST" action="{{ route('admin.tags.update', $tag) }}" style="display:flex;gap:0.5rem;align-items:center;">
                        @csrf @method('PUT')
                        <input type="text" class="form-input" name="name" value="{{ $tag->name }}" required style="flex:1;max-width:300px;">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="toggleTagEdit({{ $tag->id }})">Cancel</button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <p class="empty-state-title">No Tags Yet</p>
                <p class="empty-state-description">Create tags to organize your projects and blog posts.</p>
                <button class="btn btn-primary" onclick="document.getElementById('add-modal').classList.toggle('active')">Create First Tag</button>
            </div>
        @endif
    </div>
</div>

<div id="add-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header"><h3 style="font-weight:600;">Add Tag</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.tags.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tag Name *</label>
                    <input type="text" class="form-input" name="name" required placeholder="e.g. Laravel, Vue.js, Docker">
                    <p class="form-help">The slug will be automatically generated from the name.</p>
                </div>
                <button class="btn btn-primary">Create Tag</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleTagEdit(id) {
    const el = document.getElementById('tag-edit-' + id);
    if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
@endsection
