@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">About Section</h2></div>
<form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-3 gap-6">
        <div class="col-span-2">
            <div class="card mb-6">
                <div class="form-group"><label class="form-label">Title *</label><input type="text" class="form-input" name="title" value="{{ old('title', $about->title ?? '') }}" required></div>
                <div class="form-group"><label class="form-label">Subtitle</label><input type="text" class="form-input" name="subtitle" value="{{ old('subtitle', $about->subtitle ?? '') }}"></div>
                <div class="form-group"><label class="form-label">Description *</label><textarea class="form-textarea" name="description" rows="8" required>{{ old('description', $about->description ?? '') }}</textarea></div>
                <div class="form-group"><label class="form-label">Highlights (one per line)</label><textarea class="form-textarea" name="highlights" rows="5" placeholder="Laravel Expert&#10;Vue.js Developer&#10;Cloud Architecture">{{ is_array($about->highlights ?? null) ? implode("\n", $about->highlights) : '' }}</textarea></div>
                <div class="form-group"><label class="form-label">Languages (one per line)</label><textarea class="form-textarea" name="languages" rows="3" placeholder="English&#10;Spanish">{{ is_array($about->languages ?? null) ? implode("\n", $about->languages) : '' }}</textarea></div>
            </div>
        </div>
        <div>
            <div class="card mb-6">
                <div class="form-group">
                    <label class="form-label">Profile Image</label>
                    <input type="file" class="form-input" name="profile_image" accept="image/*">
                    @if($about->profile_image)
                        <div style="position:relative;margin-top:0.5rem;">
                            <img src="{{ asset('storage/'.$about->profile_image) }}" style="border-radius:var(--radius);max-height:150px;width:100%;object-fit:cover;">
                            <button type="button" class="btn btn-danger btn-sm" style="position:absolute;top:4px;right:4px;padding:0.25rem 0.5rem;font-size:0.75rem;" onclick="document.getElementById('remove_profile_image').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label">CV File</label>
                    <input type="file" class="form-input" name="cv_file" accept=".pdf,.doc,.docx">
                    @if($about->cv_file)
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;">
                            <span style="font-size:0.8125rem;color:var(--text-muted);">Current: {{ basename($about->cv_file) }}</span>
                            <button type="button" class="btn btn-ghost btn-sm" style="color:var(--color-danger);font-size:0.75rem;" onclick="document.getElementById('remove_cv_file').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_cv_file" id="remove_cv_file" value="0">
                    @endif
                </div>
                <div class="form-group"><label class="form-label">Experience Years</label><input type="number" class="form-input" name="experience_years" value="{{ $about->experience_years ?? '' }}" min="0"></div>
                <div class="form-group"><label class="form-label">Location</label><input type="text" class="form-input" name="location" value="{{ $about->location ?? '' }}"></div>
                <div class="form-group"><label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_active" value="1" {{ ($about->is_active ?? true) ? 'checked' : '' }}> Active</label></div>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save About Section</button>
        </div>
    </div>
</form>
@endsection
