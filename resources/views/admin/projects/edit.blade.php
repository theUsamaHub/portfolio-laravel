@extends('layouts.admin')
@section('admin-content')
<div class="mb-6">
    <h2 style="font-size: 1.25rem; font-weight: 700;">Edit Project</h2>
</div>

<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid grid-3 gap-6">
        {{-- Main Content --}}
        <div class="col-span-2">
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Project Details</h3>
                <div class="form-group">
                    <label class="form-label">Project Name *</label>
                    <input type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Short Description</label>
                    <input type="text" class="form-input" name="short_description" value="{{ old('short_description', $project->short_description) }}" maxlength="500">
                </div>
                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea class="form-textarea" name="description" rows="8" required>{{ old('description', $project->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Content (Rich Text)</label>
                    <textarea class="form-textarea" name="content" rows="12">{{ old('content', $project->content) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Publishing</h3>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $project->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="project_category_id">
                        <option value="">None</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('project_category_id', $project->project_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        Featured Project
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-input" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}">
                </div>
            </div>

            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Thumbnail</h3>
                <div class="form-group">
                    <input type="file" class="form-input" name="thumbnail" accept="image/*">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" style="margin-top: 0.5rem; border-radius: var(--radius); max-height: 150px; width: 100%; object-fit: cover;" alt="Current thumbnail">
                    @endif
                </div>
            </div>

            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Links</h3>
                <div class="form-group">
                    <label class="form-label">Project URL</label>
                    <input type="url" class="form-input" name="project_url" value="{{ old('project_url', $project->project_url) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">GitHub URL</label>
                    <input type="url" class="form-input" name="github_url" value="{{ old('github_url', $project->github_url) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Client Name</label>
                    <input type="text" class="form-input" name="client_name" value="{{ old('client_name', $project->client_name) }}">
                </div>
            </div>

            <div class="card mb-6">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Tags</h3>
                <div class="form-group">
                    @foreach($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; font-size: 0.9375rem;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $project->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary w-full">Update Project</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
