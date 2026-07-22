@extends('layouts.frontend')

@section('title', 'Services — ' . $settings['site_name'])

@section('content')
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl));">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Services</span>
            <h1 class="vb-section__title vb-display">What I Do</h1>
            <p class="vb-body-lg" style="color: var(--vb-gray-500); max-width: 600px; margin-top: var(--space-lg);">
                End-to-end development services from concept to deployment. Clean code, solid architecture, production-ready results.
            </p>
            <div class="vb-section__divider"></div>
        </div>

        @if($services->count())
            <div class="vb-services-list" data-stagger>
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}" class="vb-service-card" data-cursor>
                        <div class="vb-service-card__top">
                            <span class="vb-service-card__icon">{{ $service->icon ?? '⚡' }}</span>
                            <span class="vb-service-card__arrow">→</span>
                        </div>
                        <h2 class="vb-service-card__title">{{ $service->name }}</h2>
                        <p class="vb-service-card__desc">{{ $service->description }}</p>
                        @if($service->features)
                            <div class="vb-service-card__features">
                                @foreach($service->features as $feature)
                                    <span class="vb-service-card__feature">{{ $feature }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if($service->price)
                            <div class="vb-service-card__price">
                                <span class="vb-service-card__price-value">${{ number_format($service->price) }}</span>
                                <span class="vb-service-card__price-unit">{{ $service->price_unit ?? 'per project' }}</span>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: var(--space-4xl) 0;" data-reveal>
                <h3 class="vb-h2" style="margin-bottom: var(--space-md);">No Services Listed</h3>
                <p class="vb-body" style="color: var(--vb-gray-500);">Check back soon for available services.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('head')
<style>
    .vb-services-list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
    }
    .vb-service-card {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
        padding: var(--space-xl);
        border: 2px solid var(--vb-gray-200);
        margin-bottom: -2px;
        margin-right: -2px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        position: relative;
    }
    .vb-service-card:hover {
        border-color: var(--vb-black);
        background: var(--vb-gray-100);
        z-index: 2;
    }
    .vb-service-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .vb-service-card__icon {
        font-size: 2rem;
    }
    .vb-service-card__arrow {
        color: var(--vb-gray-400);
        transition: all 0.3s;
        font-size: 1.25rem;
    }
    .vb-service-card:hover .vb-service-card__arrow {
        color: var(--vb-red);
        transform: translateX(8px);
    }
    .vb-service-card__title {
        font-family: var(--font-display);
        font-size: 1.125rem;
    }
    .vb-service-card__desc {
        font-size: 0.875rem;
        color: var(--vb-gray-500);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .vb-service-card__features {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-sm);
    }
    .vb-service-card__feature {
        padding: 4px 12px;
        border: 1px solid var(--vb-gray-300);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--vb-gray-500);
    }
    .vb-service-card__price {
        display: flex;
        align-items: baseline;
        gap: var(--space-sm);
        padding-top: var(--space-md);
        border-top: 1px solid var(--vb-gray-200);
    }
    .vb-service-card__price-value {
        font-family: var(--font-display);
        font-size: 1.5rem;
        color: var(--vb-red);
    }
    .vb-service-card__price-unit {
        font-size: 0.875rem;
        color: var(--vb-gray-400);
    }

    /* Dark mode */
    [data-theme="dark"] .vb-service-card { border-color: var(--vb-gray-300); }
    [data-theme="dark"] .vb-service-card:hover { border-color: var(--vb-gray-400); background: var(--vb-gray-200); }
    [data-theme="dark"] .vb-service-card__feature { border-color: var(--vb-gray-300); color: var(--vb-gray-400); }
    [data-theme="dark"] .vb-service-card__price { border-top-color: var(--vb-gray-300); }

    @media (max-width: 768px) {
        .vb-services-list { grid-template-columns: 1fr; }
    }
</style>
@endpush
