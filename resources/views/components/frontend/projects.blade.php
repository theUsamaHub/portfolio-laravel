@props(['projects'])

@if($projects->count())
<section class="vb-section vb-section--gray" id="projects">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Projects</span>
            <h2 class="vb-section__title vb-h1">Featured Work</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-projects__grid">
            @foreach($projects as $project)
                <div class="vb-project" data-reveal>
                    <div class="vb-project__image">
                        @if($project->thumbnail)
                            <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->name }}">
                        @else
                            <div style="width:100%;height:100%;background:var(--vb-gray-200);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:2rem;color:var(--vb-gray-400);">{{ substr($project->name, 0, 1) }}</div>
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
                    <div class="vb-project__overlay">
                        <a href="{{ route('projects.show', $project->slug) }}" class="vb-project__overlay-btn" data-cursor>
                            View Project
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
