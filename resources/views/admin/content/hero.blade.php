@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Hero Section</h2><p class="text-muted">Manage your homepage hero content</p></div>

<form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-3 gap-6">
        <div class="col-span-2">
            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Content</h3>
                <div class="form-group"><label class="form-label">Title *</label><input type="text" class="form-input" name="title" value="{{ old('title', $hero->title ?? '') }}" required></div>
                <div class="form-group"><label class="form-label">Subtitle</label><input type="text" class="form-input" name="subtitle" value="{{ old('subtitle', $hero->subtitle ?? '') }}"></div>
                <div class="form-group"><label class="form-label">Description</label><textarea class="form-textarea" name="description" rows="4">{{ old('description', $hero->description ?? '') }}</textarea></div>
            </div>

            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">CTA Buttons</h3>
                @php $ctas = $hero->ctas ?? []; @endphp
                <div id="ctas-container">
                    @forelse($ctas as $i => $cta)
                        <div class="flex gap-2 mb-2 items-center flex-wrap">
                            <input type="text" class="form-input" name="cta_labels[]" value="{{ $cta->label }}" placeholder="Label" style="flex:1;min-width:120px;">
                            <input type="text" class="form-input" name="cta_urls[]" value="{{ $cta->url }}" placeholder="URL" style="flex:1;min-width:120px;">
                            <select class="form-select" name="cta_styles[]" style="width:120px"><option value="primary" {{ $cta->style==='primary'?'selected':'' }}>Primary</option><option value="outline" {{ $cta->style==='outline'?'selected':'' }}>Outline</option><option value="secondary" {{ $cta->style==='secondary'?'selected':'' }}>Secondary</option></select>
                            <button type="button" class="btn btn-ghost btn-sm" onclick="this.parentElement.remove()">Remove</button>
                        </div>
                    @empty
                        <div class="flex gap-2 mb-2 items-center flex-wrap">
                            <input type="text" class="form-input" name="cta_labels[]" placeholder="Label" style="flex:1;min-width:120px;">
                            <input type="text" class="form-input" name="cta_urls[]" placeholder="URL" style="flex:1;min-width:120px;">
                            <select class="form-select" name="cta_styles[]" style="width:120px"><option value="primary">Primary</option><option value="outline">Outline</option></select>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-ghost btn-sm mt-2" onclick="addCta()">+ Add CTA</button>
            </div>

            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Rotating Professions</h3>
                <div id="professions-container">
                    @forelse($hero->professions as $p)
                        <div class="flex gap-2 mb-2 items-center">
                            <input type="text" class="form-input" name="professions[]" value="{{ $p->profession }}" placeholder="Profession">
                            <button type="button" class="btn btn-ghost btn-sm" onclick="this.parentElement.remove()">Remove</button>
                        </div>
                    @empty
                        <div class="flex gap-2 mb-2 items-center">
                            <input type="text" class="form-input" name="professions[]" placeholder="Profession">
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-ghost btn-sm mt-2" onclick="addProfession()">+ Add Profession</button>
            </div>
        </div>

        <div>
            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Profile Image</h3>
                <div class="form-group">
                    <input type="file" class="form-input" name="profile_image" accept="image/*">
                    @if($hero->profile_image)
                        <div style="position:relative;margin-top:0.5rem;">
                            <img src="{{ asset('storage/'.$hero->profile_image) }}" style="border-radius:var(--radius);max-height:120px;width:100%;object-fit:cover;">
                            <button type="button" class="btn btn-danger btn-sm" style="position:absolute;top:4px;right:4px;padding:0.25rem 0.5rem;font-size:0.75rem;" onclick="document.getElementById('remove_profile_image').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                    @endif
                </div>
            </div>

            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Background</h3>
                <div class="form-group">
                    <label class="form-label">Background Image</label>
                    <input type="file" class="form-input" name="background_image" accept="image/*">
                    @if($hero->background_image)
                        <div style="position:relative;margin-top:0.5rem;">
                            <img src="{{ asset('storage/'.$hero->background_image) }}" style="border-radius:var(--radius);max-height:80px;width:100%;object-fit:cover;">
                            <button type="button" class="btn btn-danger btn-sm" style="position:absolute;top:4px;right:4px;padding:0.25rem 0.5rem;font-size:0.75rem;" onclick="document.getElementById('remove_background_image').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_background_image" id="remove_background_image" value="0">
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label">Background Video (optional)</label>
                    <input type="file" class="form-input" name="background_video" accept="video/*">
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">MP4, WebM. Video plays as background instead of image.</p>
                    @if($hero->background_video)
                        <div style="position:relative;margin-top:0.5rem;">
                            <video src="{{ asset('storage/'.$hero->background_video) }}" style="border-radius:var(--radius);max-height:80px;width:100%;object-fit:cover;" muted></video>
                            <button type="button" class="btn btn-danger btn-sm" style="position:absolute;top:4px;right:4px;padding:0.25rem 0.5rem;font-size:0.75rem;" onclick="document.getElementById('remove_background_video').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_background_video" id="remove_background_video" value="0">
                    @endif
                </div>
            </div>

            <div class="card mb-6">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Resume File</h3>
                <div class="form-group">
                    <input type="file" class="form-input" name="resume_file" accept=".pdf,.doc,.docx">
                    @if($hero->resume_file)
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;">
                            <span style="font-size:0.8125rem;color:var(--text-muted);">Current: {{ basename($hero->resume_file) }}</span>
                            <button type="button" class="btn btn-ghost btn-sm" style="color:var(--color-danger);font-size:0.75rem;" onclick="document.getElementById('remove_resume_file').value='1';this.parentElement.style.display='none';">Remove</button>
                        </div>
                        <input type="hidden" name="remove_resume_file" id="remove_resume_file" value="0">
                    @endif
                </div>
            </div>

            <div class="card mb-6">
                <div class="form-group"><label style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_active" value="1" {{ ($hero->is_active ?? true) ? 'checked' : '' }}> Active</label></div>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save Hero Section</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
function addCta() {
    const c = document.getElementById('ctas-container');
    c.insertAdjacentHTML('beforeend', '<div class="flex gap-2 mb-2 items-center flex-wrap"><input type="text" class="form-input" name="cta_labels[]" placeholder="Label" style="flex:1;min-width:120px;"><input type="text" class="form-input" name="cta_urls[]" placeholder="URL" style="flex:1;min-width:120px;"><select class="form-select" name="cta_styles[]" style="width:120px"><option value="primary">Primary</option><option value="outline">Outline</option></select><button type="button" class="btn btn-ghost btn-sm" onclick="this.parentElement.remove()">Remove</button></div>');
}
function addProfession() {
    const p = document.getElementById('professions-container');
    p.insertAdjacentHTML('beforeend', '<div class="flex gap-2 mb-2 items-center"><input type="text" class="form-input" name="professions[]" placeholder="Profession"><button type="button" class="btn btn-ghost btn-sm" onclick="this.parentElement.remove()">Remove</button></div>');
}
</script>
@endpush
@endsection
