@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Clients</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Client</button></div>
<div class="grid grid-3 gap-4">
    @forelse($items as $item)
        <div class="card text-center">
            <div class="flex justify-between items-center mb-2">
                <strong>{{ $item->name }}</strong>
                <div class="card-actions" style="justify-content:flex-end;">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.clients.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Del</button></form>
                </div>
            </div>
            @if($item->logo)<img src="{{ asset('storage/'.$item->logo) }}" style="max-height:60px;margin:0 auto;">@endif
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);text-align:left;">
                <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="form-group"><label class="form-label">Name</label><input type="text" class="form-input" name="name" value="{{ $item->name }}" required></div>
                    <div class="form-group"><label class="form-label">URL</label><input type="url" class="form-input" name="url" value="{{ $item->url }}"></div>
                    <div class="form-group"><label class="form-label">Logo</label><input type="file" class="form-input" name="logo" accept="image/*"></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Clients Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay"><div class="modal"><div class="modal-header"><h3 style="font-weight:600;">Add Client</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
    <div class="modal-body"><form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">@csrf
        <div class="form-group"><label class="form-label">Name *</label><input type="text" class="form-input" name="name" required></div>
        <div class="form-group"><label class="form-label">URL</label><input type="url" class="form-input" name="url"></div>
        <div class="form-group"><label class="form-label">Logo</label><input type="file" class="form-input" name="logo" accept="image/*"></div>
        <button class="btn btn-primary">Add Client</button>
    </form></div></div></div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
