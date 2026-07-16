@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Work Experience</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Experience</button></div>
<div class="grid gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start">
                <div><h4 style="font-weight:600;">{{ $item->position }}</h4><p style="color:var(--color-primary);font-size:0.9375rem;">{{ $item->company }}{{ $item->location ? ' - '.$item->location : '' }}</p>
                <p style="font-size:0.8125rem;color:var(--text-muted);">{{ $item->start_date->format('M Y') }} - {{ $item->is_current ? 'Present' : ($item->end_date ? $item->end_date->format('M Y') : 'N/A') }}</p></div>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.experiences.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            @if($item->description)<p style="margin-top:0.5rem;color:var(--text-secondary);font-size:0.9375rem;">{{ $item->description }}</p>@endif
            @if($item->achievements && count($item->achievements))<ul style="margin-top:0.5rem;padding-left:1.25rem;">@foreach($item->achievements as $a)<li style="font-size:0.875rem;color:var(--text-secondary);">{{ $a }}</li>@endforeach</ul>@endif
            {{-- Edit Form --}}
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Company</label><input type="text" class="form-input" name="company" value="{{ $item->company }}" required></div>
                        <div class="form-group"><label class="form-label">Position</label><input type="text" class="form-input" name="position" value="{{ $item->position }}" required></div>
                        <div class="form-group"><label class="form-label">Location</label><input type="text" class="form-input" name="location" value="{{ $item->location }}"></div>
                        <div class="form-group"><label class="form-label">Employment Type</label><select class="form-select" name="employment_type"><option value="">Select...</option>@foreach(['Full-time','Part-time','Contract','Freelance','Internship'] as $t)<option {{ $item->employment_type === $t ? 'selected' : '' }}>{{ $t }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="form-label">Start Date</label><input type="date" class="form-input" name="start_date" value="{{ $item->start_date->format('Y-m-d') }}" required></div>
                        <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-input" name="end_date" value="{{ $item->end_date?->format('Y-m-d') }}"></div>
                    </div>
                    <div class="form-group"><label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_current" value="1" {{ $item->is_current ? 'checked' : '' }}> Currently working here</label></div>
                    <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="2">{{ $item->description }}</textarea></div>
                    <div class="form-group"><label class="form-label">Achievements (one per line)</label><textarea class="form-textarea" name="achievements" rows="3">{{ is_array($item->achievements) ? implode("\n", $item->achievements) : '' }}</textarea></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state"><p class="empty-state-title">No Experience Yet</p></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal modal-lg">
        <div class="modal-header"><h3 style="font-weight:600;">Add Experience</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data">@csrf
                <div class="grid grid-2 gap-4">
                    <div class="form-group"><label class="form-label">Company *</label><input type="text" class="form-input" name="company" required></div>
                    <div class="form-group"><label class="form-label">Position *</label><input type="text" class="form-input" name="position" required></div>
                    <div class="form-group"><label class="form-label">Location</label><input type="text" class="form-input" name="location"></div>
                    <div class="form-group"><label class="form-label">Employment Type</label><select class="form-select" name="employment_type"><option value="">Select...</option><option>Full-time</option><option>Part-time</option><option>Contract</option><option>Freelance</option><option>Internship</option></select></div>
                    <div class="form-group"><label class="form-label">Start Date *</label><input type="date" class="form-input" name="start_date" required></div>
                    <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-input" name="end_date"></div>
                </div>
                <div class="form-group"><label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_current" value="1"> Currently working here</label></div>
                <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="3"></textarea></div>
                <div class="form-group"><label class="form-label">Achievements (one per line)</label><textarea class="form-textarea" name="achievements" rows="4" placeholder="Led team of 5 developers&#10;Reduced load time by 40%"></textarea></div>
                <button class="btn btn-primary">Add Experience</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
