@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h2></div>
<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif
    <div class="grid grid-3 gap-6">
        <div class="col-span-2">
            <div class="card mb-6">
                <div class="form-group"><label class="form-label">Title *</label><input type="text" class="form-input" name="name" value="{{ old('name', $post->name ?? '') }}" required></div>
                <div class="form-group"><label class="form-label">Excerpt</label><textarea class="form-textarea" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea></div>
                <div class="form-group"><label class="form-label">Content *</label><textarea class="form-textarea" name="content" rows="15" required>{{ old('content', $post->content ?? '') }}</textarea></div>
            </div>
        </div>
        <div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Publishing</h3>
                <div class="form-group"><label class="form-label">Status</label><select class="form-select" name="status"><option value="draft">Draft</option><option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Published</option></select></div>
                <div class="form-group"><label class="form-label">Category</label><select class="form-select" name="blog_category_id"><option value="">None</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('blog_category_id', $post->blog_category_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label" style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}> Featured</label></div>
                <div class="form-group"><label class="form-label">Published At</label><input type="datetime-local" class="form-input" name="published_at" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"></div>
            </div>
            <div class="card mb-6"><h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Featured Image</h3><input type="file" class="form-input" name="featured_image" accept="image/*">@if(isset($post) && $post->featured_image)<img src="{{ asset('storage/' . $post->featured_image) }}" style="margin-top:0.5rem;border-radius:var(--radius);max-height:120px;" alt="">@endif</div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Tags</h3>
                <div class="form-group">
                    @foreach($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; font-size: 0.9375rem;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2"><button type="submit" class="btn btn-primary w-full">{{ isset($post) ? 'Update' : 'Create' }} Post</button><a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancel</a></div>
        </div>
    </div>
</form>
@endsection
