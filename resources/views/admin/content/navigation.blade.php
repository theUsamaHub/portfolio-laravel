@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Navigation Menu</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Item</button></div>
<div class="card">
    <table class="admin-table"><thead><tr><th>Label</th><th>URL</th><th>Parent</th><th>New Tab</th><th>Active</th><th>Sort</th><th>Actions</th></tr></thead><tbody>
    @forelse($items as $item)
        <tr>
            <td style="font-weight:500;">{{ $item->label }}</td>
            <td style="font-size:0.875rem;color:var(--text-muted);">{{ $item->url ?? '-' }}</td>
            <td>{{ $item->parent_id ? 'Child' : 'Top-level' }}</td>
            <td>{{ $item->open_in_new_tab ? 'Yes' : 'No' }}</td>
            <td><span class="badge badge-sm {{ $item->is_active ? 'badge-success' : 'badge-warning' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td>{{ $item->sort_order }}</td>
            <td>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.navigation.destroy', $item) }}" onsubmit="return confirm('Delete this navigation item?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </td>
        </tr>
        <tr id="edit-{{ $item->id }}" style="display:none;">
            <td colspan="7" style="padding:1rem;background:var(--bg-secondary);">
                <form method="POST" action="{{ route('admin.navigation.store') }}">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-4 gap-4">
                        <div class="form-group"><label class="form-label">Label</label><input type="text" class="form-input" name="label" value="{{ $item->label }}" required></div>
                        <div class="form-group"><label class="form-label">URL</label><input type="text" class="form-input" name="url" value="{{ $item->url }}"></div>
                        <div class="form-group"><label class="form-label">Parent</label><select class="form-select" name="parent_id"><option value="">None (Top-level)</option>@foreach($items as $i)<option value="{{ $i->id }}" {{ $item->parent_id == $i->id ? 'selected' : '' }}>{{ $i->label }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" class="form-input" name="sort_order" value="{{ $item->sort_order }}"></div>
                    </div>
                    <div class="flex gap-4 items-center mt-2">
                        <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;"><input type="checkbox" name="open_in_new_tab" value="1" {{ $item->open_in_new_tab ? 'checked' : '' }}> Open in new tab</label>
                        <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;"><input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}> Active</label>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button>
                    </div>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="7"><div class="empty-state"><p class="empty-state-title">No Navigation Items</p></div></td></tr>
    @endforelse
    </tbody></table>
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal"><div class="modal-header"><h3 style="font-weight:600;">Add Navigation Item</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body"><form method="POST" action="{{ route('admin.navigation.store') }}">@csrf
            <div class="form-group"><label class="form-label">Label *</label><input type="text" class="form-input" name="label" required></div>
            <div class="form-group"><label class="form-label">URL</label><input type="text" class="form-input" name="url" placeholder="/#about"></div>
            <div class="form-group"><label class="form-label">Parent</label><select class="form-select" name="parent_id"><option value="">None (Top-level)</option>@foreach($items as $i)<option value="{{ $i->id }}">{{ $i->label }}</option>@endforeach</select></div>
            <div class="flex gap-4 items-center">
                <label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="open_in_new_tab" value="1"> Open in new tab</label>
                <label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_active" value="1" checked> Active</label>
            </div>
            <button class="btn btn-primary mt-4">Add Item</button>
        </form></div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'table-row':'none';}</script>
@endpush
@endsection
