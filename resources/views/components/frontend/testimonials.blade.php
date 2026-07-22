@props(['testimonials'])

@if($testimonials->count())
<section class="vb-section vb-section--dark" id="testimonials">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline" style="color: var(--vb-red);">Testimonials</span>
            <h2 class="vb-section__title vb-h1" style="color: var(--vb-white);">What Clients Say</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-testimonials__grid">
            @foreach($testimonials as $testimonial)
                <div class="vb-testimonial" data-reveal>
                    <blockquote class="vb-testimonial__quote">
                        {{ $testimonial->content }}
                    </blockquote>
                    <div class="vb-testimonial__author">
                        <div class="vb-testimonial__avatar">
                            {{ strtoupper(substr($testimonial->client_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="vb-testimonial__name">{{ $testimonial->client_name }}</div>
                            <div class="vb-testimonial__role">
                                {{ $testimonial->client_position }}
                                @if($testimonial->client_company) at {{ $testimonial->client_company }}@endif
                            </div>
                        </div>
                        @if($testimonial->rating)
                            <div class="vb-testimonial__rating">
                                @for($i = 0; $i < $testimonial->rating; $i++)★@endfor
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
