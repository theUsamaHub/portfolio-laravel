@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Testimonials</h2><button class="btn btn-primary btn-sm" onclick="document.getElementById('add-modal').classList.toggle('active')">+ Add Testimonial</button></div>
<div class="grid grid-2 gap-4">
    @forelse($items as $item)
        <div class="card">
            <div class="flex justify-between items-start mb-2">
                <h4 style="font-weight:600;">{{ $item->client_name }}</h4>
                <div class="card-actions">
                    <button class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Edit</button>
                    <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm" style="color:var(--color-danger);">Delete</button></form>
                </div>
            </div>
            @if($item->client_position || $item->client_company)<p style="font-size:0.8125rem;color:var(--text-muted);">{{ $item->client_position }}{{ $item->client_company ? ' at '.$item->client_company : '' }}</p>@endif
            @if($item->rating)<p style="color:var(--color-warning);">{{ str_repeat('★', $item->rating) }}</p>@endif
            <p style="font-style:italic;color:var(--text-secondary);font-size:0.9375rem;">"{{ $item->content }}"</p>

            {{-- Edit Form --}}
            <div id="edit-{{ $item->id }}" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);">
                <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="edit_id" value="{{ $item->id }}">
                    <div class="grid grid-2 gap-4">
                        <div class="form-group"><label class="form-label">Client Name</label><input type="text" class="form-input" name="client_name" value="{{ $item->client_name }}" required></div>
                        <div class="form-group"><label class="form-label">Position</label><input type="text" class="form-input" name="client_position" value="{{ $item->client_position }}"></div>
                        <div class="form-group"><label class="form-label">Company</label><input type="text" class="form-input" name="client_company" value="{{ $item->client_company }}"></div>
                        <div class="form-group"><label class="form-label">Rating</label><input type="number" class="form-input" name="rating" value="{{ $item->rating }}" min="1" max="5"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Content</label><textarea class="form-textarea" name="content" rows="3" required>{{ $item->content }}</textarea></div>
                    <div class="flex gap-2"><button type="submit" class="btn btn-primary btn-sm">Save</button><button type="button" class="btn btn-ghost btn-sm" onclick="toggleEdit('edit-{{ $item->id }}')">Cancel</button></div>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;"><div class="empty-state"><p class="empty-state-title">No Testimonials Yet</p></div></div>
    @endforelse
</div>
<div id="add-modal" class="modal-overlay">
    <div class="modal modal-lg">
        <div class="modal-header"><h3 style="font-weight:600;">Add Testimonial</h3><button class="modal-close" onclick="document.getElementById('add-modal').classList.remove('active')">&times;</button></div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">@csrf
                <div class="grid grid-2 gap-4">
                    <div class="form-group"><label class="form-label">Client Name *</label><input type="text" class="form-input" name="client_name" required></div>
                    <div class="form-group"><label class="form-label">Position</label><input type="text" class="form-input" name="client_position"></div>
                    <div class="form-group"><label class="form-label">Company</label><input type="text" class="form-input" name="client_company"></div>
                    <div class="form-group"><label class="form-label">Rating (1-5)</label><input type="number" class="form-input" name="rating" min="1" max="5" value="5"></div>
                    <div class="form-group"><label class="form-label">Avatar</label><input type="file" class="form-input" name="client_image" accept="image/*"></div>
                </div>
                <div class="form-group"><label class="form-label">Content *</label><textarea class="form-textarea" name="content" rows="4" required></textarea></div>
                <div class="form-group"><label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_featured" value="1"> Featured</label></div>
                <button class="btn btn-primary">Add Testimonial</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>function toggleEdit(id){const e=document.getElementById(id);if(e)e.style.display=e.style.display==='none'?'block':'none';}</script>
@endpush
@endsection
