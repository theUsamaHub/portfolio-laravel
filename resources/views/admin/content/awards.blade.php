@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Awards</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Award</button></div>
<div class="grid grid-2 gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start">
                <div>
                    <h4 style="font-weight:600;">{{ $item->name }}</h4>
                    <p style="color:var(--color-primary);font-size:0.9375rem;">{{ $item->organization }}</p>
                    <p style="font-size:0.8125rem;color:var(--text-muted);">{{ $item->date->format('M Y') }}</p>
                    @if($item->description)<p style="margin-top:0.5rem;color:var(--text-secondary);font-size:0.875rem;">{{ $item->description }}</p>@endif
                </div>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.awards.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.awards.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Name</label><input type="text" class="form-input" name="name" value="{{ $item->name }}" required></div>
                        <div class="form-group"><label class="form-label">Organization</label><input type="text" class="form-input" name="organization" value="{{ $item->organization }}" required></div>
                        <div class="form-group"><label class="form-label">Date</label><input type="date" class="form-input" name="date" value="{{ $item->date->format('Y-m-d') }}" required></div>
                        <div class="form-group"><label class="form-label">URL</label><input type="url" class="form-input" name="url" value="{{ $item->url }}"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="2">{{ $item->description }}</textarea></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Awards Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay"><div class="modal"><div class="modal-header"><h3 style="font-weight:600;">Add Award</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
    <div class="modal-body"><form method="POST" action="{{ route('admin.awards.store') }}" enctype="multipart/form-data">@csrf
        <div class="grid grid-2 gap-4"><div class="form-group"><label class="form-label">Name *</label><input type="text" class="form-input" name="name" required></div><div class="form-group"><label class="form-label">Organization *</label><input type="text" class="form-input" name="organization" required></div><div class="form-group"><label class="form-label">Date *</label><input type="date" class="form-input" name="date" required></div><div class="form-group"><label class="form-label">URL</label><input type="url" class="form-input" name="url"></div></div>
        <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="3"></textarea></div>
        <button class="btn btn-primary">Add Award</button>
    </form></div></div></div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
