@extends('layouts.frontend')

@section('title', $service->name . ' — ' . $settings['site_name'])

@section('content')
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl));">
    <div class="vb-container">
        {{-- Breadcrumb --}}
        <div data-reveal style="margin-bottom: var(--space-xl);">
            <a href="{{ route('home') }}" class="vb-body-sm" style="color: var(--vb-gray-500); text-decoration: none;">Home</a>
            <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
            <a href="{{ route('services.index') }}" class="vb-body-sm" style="color: var(--vb-gray-500); text-decoration: none;">Services</a>
            <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
            <span class="vb-body-sm" style="color: var(--vb-black);">{{ $service->name }}</span>
        </div>

        <div class="vb-service-detail" data-reveal>
            <div class="vb-service-detail__icon">{{ $service->icon ?? '⚡' }}</div>
            <h1 class="vb-display" style="font-size: clamp(2rem, 5vw, 3.5rem);">{{ $service->name }}</h1>
        </div>

        @if($service->price)
            <div class="vb-service-detail__price" data-reveal data-delay="0.1">
                <span class="vb-service-detail__price-value">${{ number_format($service->price) }}</span>
                <span class="vb-service-detail__price-unit">{{ $service->price_unit ?? 'per project' }}</span>
            </div>
        @endif

        <div class="vb-service-detail__content" data-reveal data-delay="0.2">
            <p class="vb-body-lg" style="color: var(--vb-gray-500); max-width: 700px; line-height: 1.8;">
                {{ $service->description }}
            </p>
        </div>

        @if($service->features)
            <div class="vb-service-detail__features" data-reveal data-delay="0.3">
                <h3 class="vb-h3" style="margin-bottom: var(--space-lg);">What's Included</h3>
                <div class="vb-service-detail__features-grid">
                    @foreach($service->features as $feature)
                        <div class="vb-service-detail__feature">
                            <span class="vb-service-detail__feature-check">✓</span>
                            <span>{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="vb-service-detail__cta" data-reveal data-delay="0.4">
            <h3 class="vb-h3">Interested in this service?</h3>
            <p class="vb-body" style="color: var(--vb-gray-500); margin-bottom: var(--space-xl);">Let's discuss how I can help with your project.</p>
            <a href="{{ route('home') }}#contact" class="vb-btn vb-btn--primary magnetic" data-cursor>Get In Touch →</a>
        </div>

        {{-- Related Services --}}
        @if($relatedServices->count())
            <div style="margin-top: var(--space-4xl);">
                <div class="vb-section__header" data-reveal>
                    <span class="vb-section__overline vb-overline">More Services</span>
                    <h2 class="vb-section__title vb-h1">Other Services</h2>
                    <div class="vb-section__divider"></div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 0;" data-stagger>
                    @foreach($relatedServices as $related)
                        <a href="{{ route('services.show', $related->slug) }}" class="vb-service-card" data-cursor>
                            <div class="vb-service-card__top">
                                <span class="vb-service-card__icon">{{ $related->icon ?? '⚡' }}</span>
                                <span class="vb-service-card__arrow">→</span>
                            </div>
                            <h3 class="vb-service-card__title" style="font-size: 1.25rem;">{{ $related->name }}</h3>
                            <p class="vb-service-card__desc">{{ Str::limit($related->description, 150) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('head')
<style>
    .vb-service-detail { margin-bottom: var(--space-xl); }
    .vb-service-detail__icon { font-size: 3rem; margin-bottom: var(--space-lg); }
    .vb-service-detail__price {
        display: inline-flex;
        align-items: baseline;
        gap: var(--space-sm);
        padding: var(--space-md) var(--space-xl);
        border: 2px solid var(--vb-red);
        margin-bottom: var(--space-xl);
    }
    .vb-service-detail__price-value {
        font-family: var(--font-display);
        font-size: 2rem;
        color: var(--vb-red);
    }
    .vb-service-detail__price-unit {
        font-size: 1rem;
        color: var(--vb-gray-500);
    }
    .vb-service-detail__features {
        margin-top: var(--space-2xl);
        padding-top: var(--space-2xl);
        border-top: 2px solid var(--vb-gray-200);
    }
    .vb-service-detail__features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-lg);
    }
    .vb-service-detail__feature {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        padding: var(--space-md);
        border: 1px solid var(--vb-gray-200);
        font-weight: 500;
    }
    .vb-service-detail__feature-check {
        color: var(--vb-red);
        font-weight: 700;
        font-size: 1.125rem;
    }
    .vb-service-detail__cta {
        margin-top: var(--space-3xl);
        padding: var(--space-2xl);
        border: 2px solid var(--vb-black);
        text-align: center;
    }

    /* Service card (reuse from index) */
    .vb-service-card {
        display: block;
        padding: var(--space-xl);
        border: 2px solid var(--vb-gray-200);
        margin-bottom: -2px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
    }
    .vb-service-card:hover { border-color: var(--vb-black); background: var(--vb-gray-100); }
    .vb-service-card__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-md); }
    .vb-service-card__icon { font-size: 2rem; }
    .vb-service-card__arrow { color: var(--vb-gray-400); transition: all 0.3s; }
    .vb-service-card:hover .vb-service-card__arrow { color: var(--vb-red); transform: translateX(8px); }
    .vb-service-card__title { font-family: var(--font-display); margin-bottom: var(--space-sm); }
    .vb-service-card__desc { font-size: 0.9375rem; color: var(--vb-gray-500); line-height: 1.6; }

    /* Dark mode */
    [data-theme="dark"] .vb-service-detail__features { border-top-color: var(--vb-gray-300); }
    [data-theme="dark"] .vb-service-detail__feature { border-color: var(--vb-gray-300); }
    [data-theme="dark"] .vb-service-detail__cta { border-color: var(--vb-gray-300); }
    [data-theme="dark"] .vb-service-card { border-color: var(--vb-gray-300); }
    [data-theme="dark"] .vb-service-card:hover { border-color: var(--vb-gray-400); background: var(--vb-gray-200); }
</style>
@endpush
