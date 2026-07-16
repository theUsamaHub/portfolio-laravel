@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Skills</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-category-modal').classList.toggle('active')">+ Add Category</button></div>

@foreach($categories as $cat)
<div class="card mb-4">
    <div class="flex justify-between items-center mb-3">
        <h3 style="font-weight: 600;">{{ $cat->name }} ({{ $cat->skills->count() }} skills)</h3>
        <div class="flex gap-2">
            <button class="btn btn-ghost btn-sm" onclick="toggleEdit('cat-{{ $cat->id }}')">Edit</button>
            <form method="POST" action="{{ route('admin.skills.category.destroy', $cat) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
        </div>
    </div>
    <div id="cat-{{ $cat->id }}" style="display:none;" class="mb-3">
        <form method="POST" action="{{ route('admin.skills.category.update', $cat) }}" class="flex gap-2 items-end">
            @csrf @method('PUT')
            <input type="text" class="form-input" name="name" value="{{ $cat->name }}" required style="flex:1">
            <input type="text" class="form-input" name="icon" value="{{ $cat->icon ?? '' }}" placeholder="Icon" style="width:80px">
            <button class="btn btn-primary btn-sm">Update</button>
        </form>
    </div>
    @if($cat->skills->count())
        <div style="overflow-x:auto;">
            <table class="admin-table"><thead><tr><th>Skill</th><th>%</th><th>Featured</th><th>Actions</th></tr></thead><tbody>
            @foreach($cat->skills as $skill)
                <tr>
                    <td>{{ $skill->name }}</td>
                    <td>{{ $skill->percentage ?? '-' }}</td>
                    <td>{{ $skill->is_featured ? 'Yes' : 'No' }}</td>
                    <td><div class="flex gap-2">
                        <button class="btn btn-ghost btn-sm" onclick="toggleEdit('skill-{{ $skill->id }}')">Edit</button>
                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Del</button></form>
                    </div></td>
                </tr>
                <tr id="skill-{{ $skill->id }}" style="display:none;"><td colspan="4">
                    <form method="POST" action="{{ route('admin.skills.update', $skill) }}" class="flex gap-2 items-end" style="padding:0.5rem 0;">@csrf @method('PUT')
                        <input type="text" class="form-input" name="name" value="{{ $skill->name }}" required style="flex:1">
                        <input type="number" class="form-input" name="percentage" value="{{ $skill->percentage }}" placeholder="%" min="0" max="100" style="width:70px">
                        <label style="font-size:0.8125rem;"><input type="checkbox" name="is_featured" value="1" {{ $skill->is_featured?'checked':'' }}> Featured</label>
                        <button class="btn btn-primary btn-sm">Save</button>
                    </form>
                </td></tr>
            @endforeach
            </tbody></table>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.skills.store') }}" class="flex gap-2 items-end mt-3" style="border-top:1px solid var(--border-color);padding-top:0.75rem;">
        @csrf
        <input type="hidden" name="skill_category_id" value="{{ $cat->id }}">
        <input type="text" class="form-input" name="name" placeholder="Skill name" required style="flex:1">
        <input type="number" class="form-input" name="percentage" placeholder="%" min="0" max="100" style="width:70px">
        <button class="btn btn-primary btn-sm">Add</button>
    </form>
</div>
@endforeach

<div id="add-category-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header"><h3 style="font-weight:600;">Add Skill Category</h3><button class="modal-close" onclick="document.getElementById('add-category-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.skills.category.store') }}">@csrf
                <div class="form-group"><label class="form-label">Name *</label><input type="text" class="form-input" name="name" required></div>
                <div class="form-group"><label class="form-label">Icon</label><input type="text" class="form-input" name="icon" placeholder="e.g. code, server"></div>
                <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="2"></textarea></div>
                <button class="btn btn-primary">Create Category</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);e.style.display=e.style.display==='none'?'table-row':'none';if(e.style.display==='')e.style.display='block';}</script>
@endpush
@endsection
