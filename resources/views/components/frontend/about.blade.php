@props(['about'])

@if($about)
<section class="vb-section" id="about">
    <div class="vb-container">
        <div class="vb-about__grid">
            <div data-reveal="left">
                <div class="vb-section__header">
                    <span class="vb-section__overline vb-overline">About</span>
                    <h2 class="vb-section__title vb-h1">{{ $about->title }}</h2>
                    <div class="vb-section__divider"></div>
                </div>

                <p class="vb-body-lg" style="margin-bottom: var(--space-xl);">{{ $about->description }}</p>

                @if($about->highlights)
                    <div class="vb-about__highlights" data-stagger>
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
                </div>
            </div>

            <div class="vb-about__image" data-reveal="right">
                @if($about->profile_image)
                    <img src="{{ Storage::url($about->profile_image) }}" alt="{{ $about->title }}">
                @else
                    <div style="aspect-ratio: 4/5; background: var(--vb-gray-100); display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: 4rem; color: var(--vb-gray-300);">J</div>
                @endif
                <div class="vb-about__image-accent"></div>
            </div>
        </div>
    </div>
</section>
@endif
