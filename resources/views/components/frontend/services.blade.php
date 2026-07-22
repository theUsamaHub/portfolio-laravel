@props(['services'])

@if($services->count())
<section class="vb-section" id="services">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Services</span>
            <h2 class="vb-section__title vb-h1">What I Do</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-services__grid" data-stagger>
            @foreach($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="vb-service" data-cursor>
                    @if($service->icon)
                        <div class="vb-service__icon">{{ $service->icon }}</div>
                    @endif
                    <h3 class="vb-service__title">{{ $service->name }}</h3>
                    <p class="vb-service__desc">{{ $service->description }}</p>
                    @if($service->features)
                        <div class="vb-service__features">
                            @foreach($service->features as $feature)
                                <span class="vb-service__feature">{{ $feature }}</span>
                            @endforeach
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
