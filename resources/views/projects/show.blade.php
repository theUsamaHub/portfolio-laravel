@extends('layouts.voicebox')

@section('content')
@include('partials.vb-header')

<main id="main-content" style="padding-top:100px;">
    <section class="vb-section">
        <div class="vb-container">
            <div class="vb-container" style="max-width:800px;">
                @if($project->category)
                    <a href="{{ route('projects.index', ['category' => $project->category->slug]) }}" class="overline" data-vb-reveal>{{ $project->category->name }}</a>
                @endif
                <h1 data-vb-reveal data-vb-delay="0.1">{{ $project->name }}</h1>

                <div class="vb-flex vb-gap-4" style="margin:24px 0;flex-wrap:wrap;font-size:14px;color:var(--vb-text-tertiary);" data-vb-reveal data-vb-delay="0.15">
                    @if($project->client_name)<span>Client: {{ $project->client_name }}</span>@endif
                    @if($project->start_date)<span>{{ $project->start_date->format('M Y') }}{{ $project->end_date ? ' - ' . $project->end_date->format('M Y') : ' - Present' }}</span>@endif
                    <span>{{ $project->views_count }} views</span>
                </div>

                @if($project->thumbnail)
                    <div style="margin:32px 0;border:4px solid var(--vb-primary);overflow:hidden;" data-vb-reveal data-vb-delay="0.2">
                        <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" style="width:100%;max-height:400px;object-fit:cover;">
                    </div>
                @endif

                {{-- Gallery --}}
                @if($project->gallery->count())
                    <div class="vb-grid vb-grid-3" style="margin:32px 0;" data-vb-reveal>
                        @foreach($project->gallery as $img)
                            <div style="border:2px solid var(--vb-border-subtle);overflow:hidden;">
                                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->alt_text ?? $project->name }}" style="width:100%;height:200px;object-fit:cover;" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif

                <div style="font-size:16px;line-height:1.7;color:var(--vb-text-secondary);margin:32px 0;" data-vb-reveal>
                    {!! $project->content ?? $project->description !!}
                </div>

                @if($project->technologies->count())
                    <div style="margin:32px 0;" data-vb-reveal>
                        <h3 style="margin-bottom:12px;">Technologies Used</h3>
                        <div class="vb-flex" style="flex-wrap:wrap;gap:8px;">
                            @foreach($project->technologies as $tech)
                                <span class="vb-chip">{{ $tech->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="vb-divider-strong"></div>

                <div class="vb-flex vb-gap-3" style="margin-top:32px;" data-vb-reveal>
                    @if($project->project_url)
                        <a href="{{ $project->project_url }}" class="vb-btn vb-btn-primary" target="_blank" rel="noopener">Live Demo</a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" class="vb-btn vb-btn-secondary" target="_blank" rel="noopener">View Code</a>
                    @endif
                </div>
            </div>

            {{-- Related Projects --}}
            @if($relatedProjects->count())
                <div class="vb-divider-strong" style="margin:64px auto;max-width:800px;"></div>
                <div style="max-width:800px;margin:0 auto;">
                    <h2 data-vb-reveal>Related Projects</h2>
                    <div class="vb-grid vb-grid-3" style="margin-top:32px;">
                        @foreach($relatedProjects as $related)
                            <a href="{{ route('projects.show', $related->slug) }}" class="vb-project-card" data-vb-reveal>
                                @if($related->thumbnail)
                                    <div class="vb-project-image">
                                        <img src="{{ \App\Helpers\ImageHelper::url($related->thumbnail, 'project') }}" alt="{{ $related->name }}" loading="lazy">
                                    </div>
                                @endif
                                <div class="vb-project-body">
                                    <h3 class="vb-project-title">{{ $related->name }}</h3>
                                    <p class="vb-project-desc">{{ Str::limit(strip_tags($related->description), 100) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@include('partials.vb-footer')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({ duration: 800, once: true, offset: 80 });
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        document.querySelectorAll('[data-vb-reveal]').forEach(el => {
            const delay = parseFloat(el.dataset.vbDelay) || 0;
            gsap.fromTo(el, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 0.8, delay, scrollTrigger: { trigger: el, start: 'top 85%', once: true } });
        });
    }
    const html = document.documentElement;
    const saved = localStorage.getItem('vb-theme') || 'light';
    html.setAttribute('data-theme', saved);
    document.getElementById('vb-theme-toggle')?.addEventListener('click', () => { const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; html.setAttribute('data-theme', next); localStorage.setItem('vb-theme', next); document.querySelector('.icon-sun').style.display = next === 'dark' ? 'none' : 'block'; document.querySelector('.icon-moon').style.display = next === 'dark' ? 'block' : 'none'; });
    window.addEventListener('scroll', () => document.getElementById('vb-header')?.classList.toggle('scrolled', window.scrollY > 50));
    const mt = document.getElementById('vb-mobile-toggle'), mm = document.getElementById('vb-mobile-menu'), mo = document.getElementById('vb-mobile-overlay'), mc = document.getElementById('vb-mobile-close');
    const openM = () => { mm?.classList.add('active'); mo?.classList.add('active'); document.body.style.overflow = 'hidden'; };
    const closeM = () => { mm?.classList.remove('active'); mo?.classList.remove('active'); document.body.style.overflow = ''; };
    mt?.addEventListener('click', () => mm?.classList.contains('active') ? closeM() : openM());
    mo?.addEventListener('click', closeM); mc?.addEventListener('click', closeM);
});
</script>
@endpush
@endsection
