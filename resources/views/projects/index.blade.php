@extends('layouts.voicebox')

@section('content')
@include('partials.vb-header')

<main id="main-content" style="padding-top:100px;">
    <section class="vb-section">
        <div class="vb-container">
            <div class="vb-section-header" data-vb-reveal>
                <span class="overline">Portfolio</span>
                <h1>All Projects</h1>
            </div>

            {{-- Filters --}}
            @if($categories->count())
                <div class="vb-filter" data-vb-reveal>
                    <a href="{{ route('projects.index') }}" class="vb-chip {{ !request('category') ? 'active' : '' }}">All</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('projects.index', ['category' => $cat->slug]) }}" class="vb-chip {{ request('category') === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            @endif

            {{-- Projects Grid --}}
            <div class="vb-grid vb-grid-3">
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="vb-project-card" data-vb-reveal data-vb-delay="{{ ($loop->index % 3) * 0.1 }}">
                        @if($project->thumbnail)
                            <div class="vb-project-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vb-project-body">
                            @if($project->category)
                                <span class="vb-chip" style="margin-bottom:12px;">{{ $project->category->name }}</span>
                            @endif
                            <h3 class="vb-project-title">{{ $project->name }}</h3>
                            <p class="vb-project-desc">{{ $project->short_description ?? Str::limit(strip_tags($project->description), 120) }}</p>
                            @if($project->technologies->count())
                                <div class="vb-project-tech">
                                    @foreach($project->technologies->take(4) as $tech)
                                        <span class="vb-chip" style="padding:2px 8px;font-size:10px;">{{ $tech->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <span class="vb-project-link">View Project &rarr;</span>
                        </div>
                    </a>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:96px 0;">
                        <p style="font-size:11px;text-transform:uppercase;letter-spacing:0.12em;color:var(--vb-secondary);margin-bottom:8px;">Portfolio</p>
                        <h2>No Projects Found</h2>
                        <p style="color:var(--vb-text-secondary);">Projects will appear here once published.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $projects->withQueryString()->links() }}</div>
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
    // Theme
    const html = document.documentElement;
    const saved = localStorage.getItem('vb-theme') || 'light';
    html.setAttribute('data-theme', saved);
    const updateIcon = () => { document.querySelector('.icon-sun').style.display = saved === 'dark' ? 'none' : 'block'; document.querySelector('.icon-moon').style.display = saved === 'dark' ? 'block' : 'none'; };
    updateIcon();
    document.getElementById('vb-theme-toggle')?.addEventListener('click', () => { const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; html.setAttribute('data-theme', next); localStorage.setItem('vb-theme', next); updateIcon(); });
    // Header scroll
    window.addEventListener('scroll', () => document.getElementById('vb-header')?.classList.toggle('scrolled', window.scrollY > 50));
    // Mobile menu
    const mt = document.getElementById('vb-mobile-toggle'), mm = document.getElementById('vb-mobile-menu'), mo = document.getElementById('vb-mobile-overlay'), mc = document.getElementById('vb-mobile-close');
    const openM = () => { mm?.classList.add('active'); mo?.classList.add('active'); document.body.style.overflow = 'hidden'; };
    const closeM = () => { mm?.classList.remove('active'); mo?.classList.remove('active'); document.body.style.overflow = ''; };
    mt?.addEventListener('click', () => mm?.classList.contains('active') ? closeM() : openM());
    mo?.addEventListener('click', closeM); mc?.addEventListener('click', closeM);
});
</script>
@endpush
@endsection
