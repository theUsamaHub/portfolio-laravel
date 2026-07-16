@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Social Links</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Link</button></div>
<div class="grid grid-2 gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);flex-shrink:0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    </div>
                    <div>
                        <strong>{{ $item->platform }}</strong>
                        <p style="font-size:0.8125rem;color:var(--text-muted);margin:0;">{{ $item->url }}</p>
                        @if($item->username)<p style="font-size:0.8125rem;color:var(--text-muted);margin:0;">@{{ $item->username }}</p>@endif
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.social-links.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.social-links.store') }}">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Platform</label><select class="form-select" name="platform"><option {{ $item->platform === 'GitHub' ? 'selected' : '' }}>GitHub</option><option {{ $item->platform === 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option><option {{ $item->platform === 'Twitter' ? 'selected' : '' }}>Twitter</option><option {{ $item->platform === 'Instagram' ? 'selected' : '' }}>Instagram</option><option {{ $item->platform === 'Facebook' ? 'selected' : '' }}>Facebook</option><option {{ $item->platform === 'YouTube' ? 'selected' : '' }}>YouTube</option><option {{ $item->platform === 'Discord' ? 'selected' : '' }}>Discord</option><option {{ $item->platform === 'Dribbble' ? 'selected' : '' }}>Dribbble</option><option {{ $item->platform === 'Behance' ? 'selected' : '' }}>Behance</option><option {{ $item->platform === 'CodePen' ? 'selected' : '' }}>CodePen</option><option {{ $item->platform === 'Figma' ? 'selected' : '' }}>Figma</option></select></div>
                        <div class="form-group"><label class="form-label">URL</label><input type="url" class="form-input" name="url" value="{{ $item->url }}" required></div>
                        <div class="form-group"><label class="form-label">Username</label><input type="text" class="form-input" name="username" value="{{ $item->username }}"></div>
                    </div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Social Links Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal"><div class="modal-header"><h3 style="font-weight:600;">Add Social Link</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body"><form method="POST" action="{{ route('admin.social-links.store') }}">@csrf
            <div class="form-group"><label class="form-label">Platform *</label><select class="form-select" name="platform"><option>GitHub</option><option>LinkedIn</option><option>Twitter</option><option>Instagram</option><option>Facebook</option><option>YouTube</option><option>Discord</option><option>Dribbble</option><option>Behance</option><option>CodePen</option><option>Figma</option></select></div>
            <div class="form-group"><label class="form-label">URL *</label><input type="url" class="form-input" name="url" required></div>
            <div class="form-group"><label class="form-label">Username</label><input type="text" class="form-input" name="username"></div>
            <button class="btn btn-primary">Add Link</button>
        </form></div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
