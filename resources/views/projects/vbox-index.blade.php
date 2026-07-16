@extends('layouts.voicebox')
@section('content')
@include('partials.vbox-header')
<main id="main-content" style="padding-top:4.5rem;">
    <section class="vbox-section">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Work</p>
                <h1 class="vbox-section-title">All Projects</h1>
            </div>

            {{-- Filters --}}
            <div class="vbox-flex vbox-flex-wrap vbox-gap-2 vbox-mb-8" data-aos="fade-up">
                <a href="{{ route('projects.index') }}" class="vbox-chip {{ !request('category') ? 'active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('projects.index', ['category' => $cat->slug]) }}" class="vbox-chip {{ request('category') === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="vbox-projects-grid">
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="vbox-project-card vbox-stagger-child">
                        @if($project->thumbnail)
                            <div class="vbox-project-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vbox-project-body">
                            @if($project->category)
                                <span class="vbox-project-category">{{ $project->category->name }}</span>
                            @endif
                            <h3 class="vbox-project-title">{{ $project->name }}</h3>
                            <p class="vbox-project-desc">{{ $project->short_description ?? Str::limit(strip_tags($project->description), 120) }}</p>
                            @if($project->technologies->count())
                                <div class="vbox-project-tech">
                                    @foreach($project->technologies->take(4) as $tech)
                                        <span class="vbox-tech-tag">{{ $tech->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="vbox-project-links">
                                <span class="vbox-btn vbox-btn-ghost vbox-btn-sm">View Project &rarr;</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:4rem 0;">
                        <p class="vbox-headline">No Projects Found</p>
                        <p class="vbox-body-sm vbox-text-secondary" style="margin-top:0.5rem;">Projects will appear here once published.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $projects->withQueryString()->links() }}</div>
        </div>
    </section>
</main>
@include('partials.vbox-footer')
@endsection
