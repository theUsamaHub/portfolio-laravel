@extends('layouts.frontend')

@section('title', 'Work — ' . $settings['site_name'])

@section('content')
{{-- Header --}}
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl));">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Work</span>
            <h1 class="vb-section__title vb-display">Featured Projects</h1>
            <p class="vb-body-lg" style="color: var(--vb-gray-500); max-width: 600px; margin-top: var(--space-lg);">
                A selection of projects I've built — from SaaS platforms to APIs and web applications.
            </p>
            <div class="vb-section__divider"></div>
        </div>

        {{-- Category Filter --}}
        @if($categories->count())
            <div data-reveal data-delay="0.2" style="display: flex; gap: var(--space-sm); flex-wrap: wrap; margin-bottom: var(--space-3xl);">
                <a href="{{ route('projects.index') }}"
                   class="vb-blog__filter {{ !request('category') ? 'vb-blog__filter--active' : '' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('projects.index', ['category' => $cat->slug]) }}"
                       class="vb-blog__filter {{ request('category') === $cat->slug ? 'vb-blog__filter--active' : '' }}">
                        {{ $cat->name }}
                        <span class="vb-blog__filter-count">{{ $cat->projects_count }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Projects Grid --}}
        @if($projects->count())
            <div class="vb-projects__grid" data-stagger>
                @foreach($projects as $project)
                    <div class="vb-project">
                        <a href="{{ route('projects.show', $project->slug) }}" class="vb-project__link">
                            <div class="vb-project__image">
                                @if($project->thumbnail)
                                    <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->name }}">
                                @else
                                    <div class="vb-project__placeholder">
                                        <span>{{ strtoupper(substr($project->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="vb-project__body">
                                @if($project->category)
                                    <span class="vb-project__category vb-overline">{{ $project->category->name }}</span>
                                @endif
                                <h3 class="vb-project__title">{{ $project->name }}</h3>
                                @if($project->short_description)
                                    <p class="vb-project__desc">{{ $project->short_description }}</p>
                                @endif
                                @if($project->tags->count())
                                    <div class="vb-project__tags">
                                        @foreach($project->tags->take(4) as $tag)
                                            <span class="vb-project__tag">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="vb-project__overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="vb-project__overlay-btn" data-cursor>
                                View Project
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($projects->hasPages())
                <div style="margin-top: var(--space-3xl); display: flex; justify-content: center;" data-reveal>
                    {{ $projects->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: var(--space-4xl) 0;" data-reveal>
                <h3 class="vb-h2" style="margin-bottom: var(--space-md);">No Projects Yet</h3>
                <p class="vb-body" style="color: var(--vb-gray-500);">Check back soon for new work.</p>
            </div>
        @endif
    </div>
</section>
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
    .vb-blog__filter {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 16px; border: 2px solid var(--vb-gray-300);
        font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.04em; color: var(--vb-gray-500); transition: all 0.3s;
        text-decoration: none;
    }
    .vb-blog__filter:hover, .vb-blog__filter--active {
        background: var(--vb-black); border-color: var(--vb-black); color: var(--vb-white);
    }
    .vb-blog__filter-count {
        font-size: 0.6875rem; background: var(--vb-gray-200);
        color: var(--vb-gray-500); padding: 1px 6px;
    }
    .vb-blog__filter--active .vb-blog__filter-count {
        background: rgba(255,255,255,0.2); color: var(--vb-white);
    }
</style>
@endpush
