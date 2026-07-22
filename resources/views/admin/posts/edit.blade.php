@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Edit Post</h2></div>
<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-3 gap-6">
        <div class="col-span-2">
            <div class="card mb-6">
                <div class="form-group"><label class="form-label">Title *</label><input type="text" class="form-input" name="name" value="{{ old('name', $post->name) }}" required></div>
                <div class="form-group"><label class="form-label">Excerpt</label><textarea class="form-textarea" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea></div>
                <div class="form-group">
                    <label class="form-label">Content *</label>
                    <x-admin.rich-editor name="content" :value="old('content', $post->content)" rows="15" />
                </div>
            </div>

            {{-- Gallery Images --}}
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Gallery Images</h3>
                <p style="font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 0.75rem;">Upload multiple images. After uploading, copy the URL and insert it into the content using the 📷 Image button above.</p>
                <input type="file" class="form-input" id="galleryUpload" accept="image/*" multiple>
                <div id="galleryPreview" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.75rem;"></div>
                <div id="galleryUrls" style="margin-top: 0.75rem;"></div>
            </div>
        </div>
        <div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Publishing</h3>
                <div class="form-group"><label class="form-label">Status</label><select class="form-select" name="status"><option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option><option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option><option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archived</option></select></div>
                <div class="form-group"><label class="form-label">Category</label><select class="form-select" name="blog_category_id"><option value="">None</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('blog_category_id', $post->blog_category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label" style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}> Featured</label></div>
                <div class="form-group"><label class="form-label">Published At</label><input type="datetime-local" class="form-input" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"></div>
            </div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Featured Image</h3>
                <input type="file" class="form-input" name="featured_image" accept="image/*">
                @if($post->featured_image)<img src="{{ asset('storage/'.$post->featured_image) }}" style="margin-top:0.5rem;border-radius:var(--radius);max-height:120px;width:100%;object-fit:cover;">@endif
            </div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">SEO</h3>
                <div class="form-group"><label class="form-label">Meta Title</label><input type="text" class="form-input" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"></div>
                <div class="form-group"><label class="form-label">Meta Description</label><textarea class="form-textarea" name="meta_description" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea></div>
                <div class="form-group"><label class="form-label">Keywords</label><input type="text" class="form-input" name="keywords" value="{{ old('keywords', $post->keywords) }}"></div>
            </div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Tags</h3>
                <div class="form-group">
                    @foreach($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; font-size: 0.9375rem;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary w-full">Update Post</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const galleryUpload = document.getElementById('galleryUpload');
    const galleryPreview = document.getElementById('galleryPreview');
    const galleryUrls = document.getElementById('galleryUrls');

    if (galleryUpload) {
        galleryUpload.addEventListener('change', async (e) => {
            const files = e.target.files;
            for (const file of files) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const response = await fetch('{{ route("admin.upload.image") }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();

                    if (data.url) {
                        const img = document.createElement('img');
                        img.src = data.url;
                        img.style.cssText = 'width:80px;height:80px;object-fit:cover;border:1px solid #ddd;border-radius:4px;cursor:pointer;';
                        img.title = 'Click to copy URL';
                        img.onclick = () => {
                            navigator.clipboard.writeText(data.url);
                            img.style.outline = '2px solid #2563EB';
                            setTimeout(() => img.style.outline = '', 1000);
                        };
                        galleryPreview.appendChild(img);

                        const urlDiv = document.createElement('div');
                        urlDiv.style.cssText = 'display:flex;align-items:center;gap:0.5rem;font-size:0.75rem;color:#64748B;font-family:monospace;';
                        urlDiv.innerHTML = `<span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${data.url}</span>
                            <button type="button" onclick="navigator.clipboard.writeText('${data.url}');this.textContent='Copied!';setTimeout(()=>this.textContent='Copy',1000)" style="padding:2px 8px;border:1px solid #ddd;background:#fff;cursor:pointer;font-size:0.75rem;border-radius:3px;">Copy</button>`;
                        galleryUrls.appendChild(urlDiv);
                    }
                } catch (err) {
                    console.error('Upload failed:', err);
                }
            }
            galleryUpload.value = '';
        });
    }
});
</script>
@endpush
@endsection
