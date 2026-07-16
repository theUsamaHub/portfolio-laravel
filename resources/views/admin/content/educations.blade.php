@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Education</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Education</button></div>
<div class="grid gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start">
                <div>
                    <h4 style="font-weight:600;">{{ $item->degree }}{{ $item->field_of_study ? ' in '.$item->field_of_study : '' }}</h4>
                    <p style="color:var(--color-primary);">{{ $item->institution }}</p>
                    <p style="font-size:0.8125rem;color:var(--text-muted);">{{ $item->start_date->format('M Y') }} - {{ $item->end_date ? $item->end_date->format('M Y') : 'Present' }}{{ $item->grade ? ' | '.$item->grade : '' }}</p>
                    @if($item->activities)<p style="font-size:0.8125rem;color:var(--text-muted);margin-top:0.25rem;">{{ $item->activities }}</p>@endif
                </div>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.educations.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.educations.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Institution</label><input type="text" class="form-input" name="institution" value="{{ $item->institution }}" required></div>
                        <div class="form-group"><label class="form-label">Degree</label><input type="text" class="form-input" name="degree" value="{{ $item->degree }}" required></div>
                        <div class="form-group"><label class="form-label">Field of Study</label><input type="text" class="form-input" name="field_of_study" value="{{ $item->field_of_study }}"></div>
                        <div class="form-group"><label class="form-label">Grade</label><input type="text" class="form-input" name="grade" value="{{ $item->grade }}"></div>
                        <div class="form-group"><label class="form-label">Start Date</label><input type="date" class="form-input" name="start_date" value="{{ $item->start_date->format('Y-m-d') }}" required></div>
                        <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-input" name="end_date" value="{{ $item->end_date?->format('Y-m-d') }}"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="2">{{ $item->description }}</textarea></div>
                    <div class="form-group"><label class="form-label">Activities</label><input type="text" class="form-input" name="activities" value="{{ $item->activities }}"></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state"><p class="empty-state-title">No Education Yet</p></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal modal-lg">
        <div class="modal-header"><h3 style="font-weight:600;">Add Education</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.educations.store') }}" enctype="multipart/form-data">@csrf
                <div class="grid grid-2 gap-4">
                    <div class="form-group"><label class="form-label">Institution *</label><input type="text" class="form-input" name="institution" required></div>
                    <div class="form-group"><label class="form-label">Degree *</label><input type="text" class="form-input" name="degree" required></div>
                    <div class="form-group"><label class="form-label">Field of Study</label><input type="text" class="form-input" name="field_of_study"></div>
                    <div class="form-group"><label class="form-label">Grade</label><input type="text" class="form-input" name="grade" placeholder="e.g. 3.8/4.0"></div>
                    <div class="form-group"><label class="form-label">Start Date *</label><input type="date" class="form-input" name="start_date" required></div>
                    <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-input" name="end_date"></div>
                </div>
                <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="3"></textarea></div>
                <div class="form-group"><label class="form-label">Activities</label><textarea class="form-textarea" name="activities" rows="2" placeholder="Dean's List, Computer Science Club"></textarea></div>
                <button class="btn btn-primary">Add Education</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
