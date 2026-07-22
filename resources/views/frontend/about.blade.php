@extends('layouts.frontend')

@section('title', 'About — ' . $settings['site_name'])

@section('content')
{{-- Header --}}
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl));">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">About</span>
            <h1 class="vb-section__title vb-display">About Me</h1>
            <div class="vb-section__divider"></div>
        </div>
    </div>
</section>

{{-- About Content --}}
@if($about)
<section class="vb-section" style="padding-top: 0;">
    <div class="vb-container">
        <div class="vb-about__grid">
            <div data-reveal="left">
                <p class="vb-body-lg" style="margin-bottom: var(--space-xl);">{{ $about->description }}</p>

                @if($about->highlights)
                    <div class="vb-about__highlights" data-stagger style="margin-top: var(--space-xl);">
                        @foreach($about->highlights as $highlight)
                            <span class="vb-about__highlight">{{ $highlight }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="vb-about__stats" data-stagger>
                    @if($about->experience_years)
                        <div>
                            <div class="vb-about__stat-number">{{ $about->experience_years }}+</div>
                            <div class="vb-about__stat-label">Years Experience</div>
                        </div>
                    @endif
                    @if($about->location)
                        <div>
                            <div class="vb-about__stat-number" style="font-size: 1.5rem;">{{ $about->location }}</div>
                            <div class="vb-about__stat-label">Location</div>
                        </div>
                    @endif
                    @if($about->languages)
                        <div>
                            <div class="vb-about__stat-number" style="font-size: 1.5rem;">{{ count($about->languages) }}</div>
                            <div class="vb-about__stat-label">Languages</div>
                        </div>
                    @endif
                    @if($about->cv_file)
                        <div>
                            <a href="{{ Storage::url($about->cv_file) }}" class="vb-btn vb-btn--primary magnetic" target="_blank" data-cursor style="margin-top: var(--space-sm);">Download CV →</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="vb-about__image" data-reveal="right">
                @if($about->profile_image)
                    <img src="{{ Storage::url($about->profile_image) }}" alt="{{ $about->title }}">
                @else
                    <div style="aspect-ratio: 4/5; background: var(--vb-gray-100); display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: 4rem; color: var(--vb-gray-300);">U</div>
                @endif
                <div class="vb-about__image-accent"></div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Skills --}}
@if($skillCategories->count())
<section class="vb-section vb-section--gray">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Skills</span>
            <h2 class="vb-section__title vb-h1">My Expertise</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-skills__grid" data-stagger>
            @foreach($skillCategories as $index => $category)
                <div class="vb-skill-card">
                    <div class="vb-skill-card__top">
                        <span class="vb-skill-card__number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="vb-skill-card__icon">
                            @if($category->name === 'Backend')
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            @elseif($category->name === 'Frontend')
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                            @else
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                            @endif
                        </div>
                    </div>
                    <h3 class="vb-skill-card__title">{{ $category->name }}</h3>
                    <div class="vb-skill-card__list">
                        @foreach($category->skills->sortBy('sort_order') as $skill)
                            <div class="vb-skill-card__item">
                                <div class="vb-skill-card__item-top">
                                    <span class="vb-skill-card__item-name">{{ $skill->name }}</span>
                                    <span class="vb-skill-card__item-pct">{{ $skill->percentage }}%</span>
                                </div>
                                <div class="vb-skill-card__bar">
                                    <div class="vb-skill-card__bar-fill" data-width="{{ $skill->percentage }}%" style="width: {{ $skill->percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Experience & Education --}}
@if($experiences->count() || $educations->count())
<section class="vb-section">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Journey</span>
            <h2 class="vb-section__title vb-h1">Experience & Education</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl);">
            @if($experiences->count())
                <div data-reveal="left">
                    <h3 class="vb-h3" style="margin-bottom: var(--space-xl);">Work Experience</h3>
                    <div class="vb-timeline">
                        @foreach($experiences as $exp)
                            <div class="vb-timeline__item">
                                <div class="vb-timeline__dot"></div>
                                <div class="vb-timeline__date">
                                    {{ $exp->start_date->format('M Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : 'Present') }}
                                </div>
                                <h4 class="vb-timeline__title">{{ $exp->position }}</h4>
                                <div class="vb-timeline__subtitle">
                                    {{ $exp->company }}
                                    @if($exp->location) · {{ $exp->location }}@endif
                                </div>
                                @if($exp->description)
                                    <p class="vb-timeline__desc">{{ $exp->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($educations->count())
                <div data-reveal="right">
                    <h3 class="vb-h3" style="margin-bottom: var(--space-xl);">Education</h3>
                    <div class="vb-timeline">
                        @foreach($educations as $edu)
                            <div class="vb-timeline__item">
                                <div class="vb-timeline__dot"></div>
                                <div class="vb-timeline__date">
                                    {{ $edu->start_date->format('M Y') }} — {{ $edu->end_date ? $edu->end_date->format('M Y') : 'Present' }}
                                </div>
                                <h4 class="vb-timeline__title">{{ $edu->degree }}</h4>
                                <div class="vb-timeline__subtitle">
                                    {{ $edu->institution }}
                                    @if($edu->field_of_study) · {{ $edu->field_of_study }}@endif
                                </div>
                                @if($edu->description)
                                    <p class="vb-timeline__desc">{{ $edu->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Statistics --}}
@if($statistics->count())
<section class="vb-section vb-section--dark">
    <div class="vb-container">
        <div class="vb-stats" data-stagger>
            @foreach($statistics as $stat)
                <div class="vb-stat">
                    <div class="vb-stat__value">
                        <span data-count="{{ $stat->value }}" data-suffix="{{ $stat->suffix ?? '' }}">0{{ $stat->suffix ?? '' }}</span>
                    </div>
                    <div class="vb-stat__label">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
