@extends('layouts.frontend')

@section('title', $project->meta_title ?? $project->name . ' — ' . $settings['site_name'])
@section('description', $project->meta_description ?? $project->short_description)

@section('content')
{{-- Header --}}
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl)); padding-bottom: var(--space-2xl);">
    <div class="vb-container">
        {{-- Breadcrumb --}}
        <div data-reveal style="margin-bottom: var(--space-xl);">
            <a href="{{ route('home') }}" class="vb-body-sm" style="color: var(--vb-gray-500); text-decoration: none;">Home</a>
            <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
            <a href="{{ route('projects.index') }}" class="vb-body-sm" style="color: var(--vb-gray-500); text-decoration: none;">Work</a>
            <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
            <span class="vb-body-sm" style="color: var(--vb-black);">{{ Str::limit($project->name, 40) }}</span>
        </div>

        {{-- Category --}}
        @if($project->category)
            <div data-reveal data-delay="0.1" style="margin-bottom: var(--space-lg);">
                <span class="vb-project__cat-badge">{{ $project->category->name }}</span>
            </div>
        @endif

        {{-- Title --}}
        <h1 class="vb-display" data-reveal data-delay="0.2" style="font-size: clamp(2rem, 5vw, 3.5rem); margin-bottom: var(--space-lg);">
            {{ $project->name }}
        </h1>

        {{-- Short Description --}}
        @if($project->short_description)
            <p class="vb-body-lg" data-reveal data-delay="0.3" style="color: var(--vb-gray-500); max-width: 700px; line-height: 1.7;">
                {{ $project->short_description }}
            </p>
        @endif

        {{-- Meta Row --}}
        <div class="vb-project__meta-row" data-reveal data-delay="0.4">
            @if($project->client_name)
                <div class="vb-project__meta-item">
                    <span class="vb-overline" style="color: var(--vb-gray-400);">Client</span>
                    <span style="font-weight: 600;">{{ $project->client_name }}</span>
                </div>
            @endif
            @if($project->start_date)
                <div class="vb-project__meta-item">
                    <span class="vb-overline" style="color: var(--vb-gray-400);">Timeline</span>
                    <span style="font-weight: 600;">
                        {{ $project->start_date->format('M Y') }}
                        — {{ $project->end_date ? $project->end_date->format('M Y') : 'Present' }}
                    </span>
                </div>
            @endif
            @if($project->technologies->count())
                <div class="vb-project__meta-item">
                    <span class="vb-overline" style="color: var(--vb-gray-400);">Stack</span>
                    <div style="display: flex; gap: var(--space-xs); flex-wrap: wrap;">
                        @foreach($project->technologies as $tech)
                            <span class="vb-project__tech-badge">{{ $tech->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="vb-project__actions" data-reveal data-delay="0.5">
            @if($project->project_url)
                <a href="{{ $project->project_url }}" class="vb-btn vb-btn--primary magnetic" target="_blank" data-cursor>
                    Live Preview →
                </a>
            @endif
            @if($project->github_url)
                <a href="{{ $project->github_url }}" class="vb-btn magnetic" target="_blank" data-cursor>
                    View Code →
                </a>
            @endif
        </div>
    </div>
</section>

{{-- Featured Image --}}
@if($project->thumbnail)
<section style="padding: 0 var(--space-xl); margin-bottom: var(--space-3xl);">
    <div class="vb-container">
        <div class="vb-project__featured" data-reveal style="border: 2px solid var(--vb-black); overflow: hidden;">
            <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->name }}" style="width: 100%; max-height: 600px; object-fit: cover;">
        </div>
    </div>
</section>
@endif

{{-- Gallery --}}
@if($project->gallery->count())
<section style="padding: 0 var(--space-xl); margin-bottom: var(--space-3xl);">
    <div class="vb-container">
        <div class="vb-project__gallery" data-stagger>
            @foreach($project->gallery->sortBy('sort_order') as $image)
                <div class="vb-project__gallery-item" style="border: 2px solid var(--vb-black); overflow: hidden;">
                    <img src="{{ Storage::url($image->image) }}" alt="{{ $image->alt_text ?? $project->name }}" style="width: 100%; object-fit: cover;">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Content --}}
@if($project->content)
<section class="vb-section">
    <div class="vb-container">
        <div style="max-width: 800px;">
            <div class="vb-project__content" data-reveal="left">
                {!! $project->content !!}
            </div>
        </div>
    </div>
</section>
@endif

{{-- Tags --}}
@if($project->tags->count())
<section style="padding: 0 var(--space-xl); margin-bottom: var(--space-3xl);">
    <div class="vb-container">
        <div data-reveal style="padding-top: var(--space-xl); border-top: 2px solid var(--vb-gray-200);">
            <span class="vb-overline" style="color: var(--vb-gray-400); display: block; margin-bottom: var(--space-md);">Tags</span>
            <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap;">
                @foreach($project->tags as $tag)
                    <span class="vb-blog__tag">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- Related Projects --}}
@if($relatedProjects->count())
<section class="vb-section vb-section--gray">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">More Work</span>
            <h2 class="vb-section__title vb-h1">Related Projects</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-projects__grid" data-stagger style="grid-template-columns: repeat(3, 1fr);">
            @foreach($relatedProjects as $related)
                <div class="vb-project">
                    <a href="{{ route('projects.show', $related->slug) }}" class="vb-project__link">
                        <div class="vb-project__image">
                            @if($related->thumbnail)
                                <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->name }}">
                            @else
                                <div class="vb-project__placeholder">
                                    <span>{{ strtoupper(substr($related->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="vb-project__body">
                            @if($related->category)
                                <span class="vb-project__category vb-overline">{{ $related->category->name }}</span>
                            @endif
                            <h3 class="vb-project__title">{{ $related->name }}</h3>
                            @if($related->short_description)
                                <p class="vb-project__desc">{{ Str::limit($related->short_description, 100) }}</p>
                            @endif
                        </div>
                    </a>
                    <div class="vb-project__overlay">
                        <a href="{{ route('projects.show', $related->slug) }}" class="vb-project__overlay-btn" data-cursor>View Project</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('head')
<style>
    .vb-project__link { display: block; color: inherit; text-decoration: none; }
    .vb-project__placeholder {
        width: 100%; height: 100%;
        background: var(--vb-gray-100);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-size: 3rem; color: var(--vb-gray-300);
    }
    .vb-project__cat-badge {
        padding: 4px 12px; border: 2px solid var(--vb-red); color: var(--vb-red);
        font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
    }
    .vb-project__meta-row {
        display: flex; gap: var(--space-2xl); flex-wrap: wrap;
        margin-top: var(--space-xl); padding-top: var(--space-xl);
        border-top: 2px solid var(--vb-gray-200);
    }
    .vb-project__meta-item { display: flex; flex-direction: column; gap: 4px; }
    .vb-project__tech-badge {
        padding: 4px 10px; border: 1px solid var(--vb-gray-300);
        font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;
    }
    .vb-project__actions {
        display: flex; gap: var(--space-md); margin-top: var(--space-xl); flex-wrap: wrap;
    }
    .vb-project__gallery {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-lg);
    }
    .vb-project__content {
        font-size: 1.0625rem; line-height: 1.8; color: var(--vb-gray-900);
    }
    .vb-project__content h2 {
        font-family: var(--font-display); font-size: 1.75rem;
        margin: var(--space-2xl) 0 var(--space-lg); line-height: 1.2;
    }
    .vb-project__content h3 {
        font-family: var(--font-display); font-size: 1.375rem;
        margin: var(--space-xl) 0 var(--space-md); line-height: 1.25;
    }
    .vb-project__content p { margin-bottom: var(--space-lg); }
    .vb-project__content ul, .vb-project__content ol {
        margin: var(--space-lg) 0; padding-left: var(--space-xl);
    }
    .vb-project__content li { margin-bottom: var(--space-sm); list-style: disc; }
    .vb-project__content ol li { list-style: decimal; }
    .vb-project__content pre {
        background: var(--vb-black); color: var(--vb-white);
        padding: var(--space-lg); margin: var(--space-xl) 0; overflow-x: auto;
    }
    .vb-project__content code {
        font-family: var(--font-mono); background: var(--vb-gray-100);
        padding: 2px 6px; font-size: 0.9em;
    }
    .vb-project__content pre code { background: none; padding: 0; color: inherit; }
    .vb-project__content blockquote {
        border-left: 4px solid var(--vb-red); padding: var(--space-md) var(--space-xl);
        margin: var(--space-xl) 0; background: var(--vb-gray-100); font-style: italic;
    }
    .vb-project__content img {
        width: 100%; border: 2px solid var(--vb-gray-200); margin: var(--space-xl) 0;
    }
    .vb-blog__tag {
        padding: 4px 12px; border: 1px solid var(--vb-gray-300);
        font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.04em; color: var(--vb-gray-500);
    }

    @media (max-width: 768px) {
        .vb-project__gallery { grid-template-columns: 1fr; }
    }
</style>
@endpush
