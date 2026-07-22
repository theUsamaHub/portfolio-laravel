@props(['skillCategories'])

@if($skillCategories->count())
<section class="vb-section vb-section--gray" id="skills">
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
