@props(['experiences', 'educations'])

@if($experiences->count() || $educations->count())
<section class="vb-section vb-section--gray" id="experience">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Experience</span>
            <h2 class="vb-section__title vb-h1">My Journey</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl);">
            @if($experiences->count())
                <div data-reveal="left">
                    <h3 class="vb-h3" style="margin-bottom: var(--space-xl);">Work</h3>
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
