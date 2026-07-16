@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Statistics</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Statistic</button></div>
<div class="grid grid-4 gap-4">
    @forelse($items as $item)
        <div class="card text-center">
            <div style="font-size:1.75rem;font-weight:700;color:var(--color-primary);">{{ $item->value }}{{ $item->suffix }}</div>
            <div style="color:var(--text-muted);margin-bottom:0.5rem;">{{ $item->label }}</div>
            <div class="card-actions" style="justify-content:center;">
                <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                <form method="POST" action="{{ route('admin.statistics.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
            </div>
            {{-- Edit Form --}}
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.statistics.store') }}">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="form-group"><input type="text" class="form-input" name="label" value="{{ $item->label }}" required style="font-size:0.8125rem;"></div>
                    <div class="flex gap-2 items-center">
                        <input type="number" class="form-input" name="value" value="{{ $item->value }}" required min="0" style="font-size:0.8125rem;flex:1;">
                        <input type="text" class="form-input" name="suffix" value="{{ $item->suffix }}" placeholder="Suffix" style="font-size:0.8125rem;width:60px;">
                    </div>
                    <div class="flex gap-2 mt-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Statistics Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay"><div class="modal"><div class="modal-header"><h3 style="font-weight:600;">Add Statistic</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
    <div class="modal-body"><form method="POST" action="{{ route('admin.statistics.store') }}">@csrf
        <div class="grid grid-2 gap-4"><div class="form-group"><label class="form-label">Label *</label><input type="text" class="form-input" name="label" required placeholder="e.g. Years Experience"></div><div class="form-group"><label class="form-label">Value *</label><input type="number" class="form-input" name="value" required min="0"></div><div class="form-group"><label class="form-label">Suffix</label><input type="text" class="form-input" name="suffix" placeholder="e.g. + or %"></div></div>
        <button class="btn btn-primary">Add Statistic</button>
    </form></div></div></div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
