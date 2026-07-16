@extends('layouts.voicebox')
@php
    $title = $project->meta_title ?? $project->name . ' | ' . \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $description = $project->meta_description ?? Str::limit(strip_tags($project->description), 160);
@endphp
@section('content')
@include('partials.vbox-header')
<main id="main-content" style="padding-top:4.5rem;">
    <article class="vbox-section">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                @if($project->category)
                    <a href="{{ route('projects.index', ['category' => $project->category->slug]) }}" class="vbox-overline vbox-text-red" style="text-decoration:none;">&larr; {{ $project->category->name }}</a>
                @endif
                <h1 class="vbox-section-title" style="margin-top:0.75rem;">{{ $project->name }}</h1>
            </div>

            @if($project->thumbnail)
                <div class="vbox-reveal" style="margin-bottom:2rem;border:2px solid var(--vbox-border-strong,#0A0A0A);overflow:hidden;">
                    <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" style="width:100%;max-height:500px;object-fit:cover;">
                </div>
            @endif

            <div class="vbox-flex vbox-flex-wrap vbox-gap-4 vbox-mb-6" style="font-size:0.875rem;color:var(--vbox-text-secondary,#525252);">
                @if($project->client_name)<span>Client: {{ $project->client_name }}</span>@endif
                @if($project->start_date)<span>{{ $project->start_date->format('M Y') }}{{ $project->end_date ? ' - '.$project->end_date->format('M Y') : ' - Present' }}</span>@endif
                <span>{{ $project->views_count }} views</span>
            </div>

            <div class="vbox-body-lg vbox-reveal" style="line-height:1.8;">
                {!! $project->content ?? $project->description !!}
            </div>

            @if($project->technologies->count())
                <div class="vbox-mt-6 vbox-reveal">
                    <p class="vbox-overline vbox-mb-4">Technologies Used</p>
                    <div class="vbox-flex vbox-flex-wrap vbox-gap-2">
                        @foreach($project->technologies as $tech)
                            <span class="vbox-chip active" style="cursor:default;">{{ $tech->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="vbox-flex vbox-gap-4 vbox-mt-6 vbox-reveal">
                @if($project->project_url)
                    <a href="{{ $project->project_url }}" class="vbox-btn vbox-btn-primary" target="_blank" rel="noopener">Live Demo</a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" class="vbox-btn vbox-btn-secondary" target="_blank" rel="noopener">View Code</a>
                @endif
            </div>

            @if($relatedProjects->count())
                <div class="vbox-border-top vbox-mt-8 vbox-pt-8 vbox-reveal">
                    <p class="vbox-section-overline vbox-mb-4">More Work</p>
                    <h2 class="vbox-headline">Related Projects</h2>
                    <div class="vbox-projects-grid" style="margin-top:2rem;">
                        @foreach($relatedProjects as $related)
                            <a href="{{ route('projects.show', $related->slug) }}" class="vbox-project-card">
                                @if($related->thumbnail)
                                    <div class="vbox-project-image">
                                        <img src="{{ \App\Helpers\ImageHelper::url($related->thumbnail, 'project') }}" alt="{{ $related->name }}" loading="lazy">
                                    </div>
                                @endif
                                <div class="vbox-project-body">
                                    <h3 class="vbox-project-title">{{ $related->name }}</h3>
                                    <p class="vbox-project-desc">{{ Str::limit(strip_tags($related->description), 100) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>
</main>
@include('partials.vbox-footer')
@endsection
