@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Certificates</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Certificate</button></div>
<div class="grid grid-3 gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start mb-2"><h4 style="font-weight:600;font-size:0.9375rem;">{{ $item->name }}</h4>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.certificates.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Del</button></form>
                </div>
            </div>
            <p style="font-size:0.875rem;color:var(--color-primary);">{{ $item->organization }}</p>
            <p style="font-size:0.8125rem;color:var(--text-muted);">Issued: {{ $item->issue_date->format('M Y') }}</p>
            @if($item->credential_url)<a href="{{ $item->credential_url }}" target="_blank" style="font-size:0.8125rem;">View Credential</a>@endif
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Name</label><input type="text" class="form-input" name="name" value="{{ $item->name }}" required></div>
                        <div class="form-group"><label class="form-label">Organization</label><input type="text" class="form-input" name="organization" value="{{ $item->organization }}" required></div>
                        <div class="form-group"><label class="form-label">Issue Date</label><input type="date" class="form-input" name="issue_date" value="{{ $item->issue_date->format('Y-m-d') }}" required></div>
                        <div class="form-group"><label class="form-label">Expiry Date</label><input type="date" class="form-input" name="expiry_date" value="{{ $item->expiry_date?->format('Y-m-d') }}"></div>
                        <div class="form-group"><label class="form-label">Credential URL</label><input type="url" class="form-input" name="credential_url" value="{{ $item->credential_url }}"></div>
                    </div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Certificates Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay"><div class="modal modal-lg"><div class="modal-header"><h3 style="font-weight:600;">Add Certificate</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
    <div class="modal-body"><form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data">@csrf
        <div class="grid grid-2 gap-4"><div class="form-group"><label class="form-label">Name *</label><input type="text" class="form-input" name="name" required></div><div class="form-group"><label class="form-label">Organization *</label><input type="text" class="form-input" name="organization" required></div><div class="form-group"><label class="form-label">Issue Date *</label><input type="date" class="form-input" name="issue_date" required></div><div class="form-group"><label class="form-label">Expiry Date</label><input type="date" class="form-input" name="expiry_date"></div><div class="form-group"><label class="form-label">Credential URL</label><input type="url" class="form-input" name="credential_url"></div></div>
        <button class="btn btn-primary">Add Certificate</button>
    </form></div></div></div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
