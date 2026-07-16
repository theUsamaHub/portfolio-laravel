@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Services</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Service</button></div>
<div class="grid grid-2 gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2">
                    @if($item->icon)
                        <span style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-primary-light);display:inline-flex;align-items:center;justify-content:center;color:var(--color-primary);font-size:0.875rem;font-weight:700;flex-shrink:0;">{{ strtoupper(substr($item->name, 0, 2)) }}</span>
                    @endif
                    <h4 style="font-weight:600;">{{ $item->name }}</h4>
                </div>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.services.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            <p style="color:var(--text-secondary);font-size:0.9375rem;">{{ Str::limit($item->description, 150) }}</p>
            @if($item->features && count($item->features))
                <ul style="margin-top:0.5rem;padding-left:1.25rem;">@foreach($item->features as $f)<li style="font-size:0.875rem;color:var(--text-secondary);">{{ $f }}</li>@endforeach</ul>
            @endif
            @if($item->price)<p style="color:var(--color-primary);font-weight:600;margin-top:0.5rem;">${{ $item->price }}<span style="font-weight:400;color:var(--text-muted);font-size:0.875rem;">/{{ $item->price_unit ?? 'project' }}</span></p>@endif

            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.services.store') }}">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Name</label><input type="text" class="form-input" name="name" value="{{ $item->name }}" required></div>
                        <div class="form-group"><label class="form-label">Icon (2-letter)</label><input type="text" class="form-input" name="icon" value="{{ $item->icon }}" maxlength="4"></div>
                        <div class="form-group"><label class="form-label">Price</label><input type="number" class="form-input" name="price" value="{{ $item->price }}" min="0" step="0.01"></div>
                        <div class="form-group"><label class="form-label">Price Unit</label><input type="text" class="form-input" name="price_unit" value="{{ $item->price_unit }}"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="3" required>{{ $item->description }}</textarea></div>
                    <div class="form-group"><label class="form-label">Features (one per line)</label><textarea class="form-textarea" name="features" rows="3">{{ is_array($item->features) ? implode("\n", $item->features) : '' }}</textarea></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Services Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal modal-lg">
        <div class="modal-header"><h3 style="font-weight:600;">Add Service</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.services.store') }}">@csrf
                <div class="grid grid-2 gap-4"><div class="form-group"><label class="form-label">Name *</label><input type="text" class="form-input" name="name" required></div><div class="form-group"><label class="form-label">Icon (2-letter)</label><input type="text" class="form-input" name="icon" placeholder="e.g. WD" maxlength="4"></div><div class="form-group"><label class="form-label">Price</label><input type="number" class="form-input" name="price" min="0" step="0.01"></div><div class="form-group"><label class="form-label">Price Unit</label><input type="text" class="form-input" name="price_unit" placeholder="e.g. per project"></div></div>
                <div class="form-group"><label class="form-label">Description *</label><textarea class="form-textarea" name="description" rows="4" required></textarea></div>
                <div class="form-group"><label class="form-label">Features (one per line)</label><textarea class="form-textarea" name="features" rows="4" placeholder="Custom Development&#10;API Integration"></textarea></div>
                <button class="btn btn-primary">Add Service</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
