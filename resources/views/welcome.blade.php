@extends('layouts.voicebox')

@section('content')
@include('partials.vb-header')

<main id="main-content">

    {{-- HERO --}}
    <section class="vb-hero" id="hero" style="position:relative;overflow:hidden;">
        @if($hero?->background_video)
            <div style="position:absolute;inset:0;z-index:0;">
                <video autoplay muted loop playsinline style="width:100%;height:100%;object-fit:cover;opacity:0.15;">
                    <source src="{{ asset('storage/'.$hero->background_video) }}" type="video/mp4">
                </video>
            </div>
        @endif

        <div class="vb-container" style="position:relative;z-index:1;">
            <div class="vb-hero-content">
                {{-- Overline with reveal --}}
                @if($hero?->subtitle)
                    <div style="overflow:hidden;margin-bottom:8px;" data-gsap-reveal>
                        <span class="overline" style="display:inline-block;transform:translateY(100%);">{{ $hero->subtitle }}</span>
                    </div>
                @endif

                {{-- Title with character-by-character reveal --}}
                <h1 class="vb-hero-title" id="hero-title" data-text="{{ $hero->title ?? 'Building Digital Experiences' }}">
                    @php $words = explode(' ', $hero->title ?? 'Building Digital Experiences'); @endphp
                    @foreach($words as $word)
                        <span style="display:inline-block;overflow:hidden;">
                            <span class="hero-word" style="display:inline-block;transform:translateY(110%);">{{ $word }}</span>
                        </span>
                        @if(!$loop->last) @endif
                    @endforeach
                </h1>

                {{-- Description with slide up --}}
                @if($hero?->description)
                    <div style="overflow:hidden;margin-bottom:32px;" data-gsap-reveal>
                        <p class="vb-hero-subtitle" style="transform:translateY(100%);">{{ $hero->description }}</p>
                    </div>
                @endif

                {{-- Rotating professions --}}
                @if($hero?->professions->count())
                    <div style="margin-bottom:32px;overflow:hidden;" data-gsap-reveal>
                        <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border:2px solid var(--vb-border-strong);background:var(--vb-surface);">
                            <span style="font-size:14px;color:var(--vb-text-secondary);">I'm a</span>
                            <span id="vb-rotating-word" style="font-weight:700;color:var(--vb-secondary);transition:opacity 0.3s;font-family:var(--vb-font-display);font-size:16px;">{{ $hero->professions->first()->profession }}</span>
                        </div>
                    </div>
                @endif

                {{-- CTAs with stagger --}}
                @if($hero?->ctas->count())
                    <div class="vb-hero-cta" data-gsap-stagger>
                        @foreach($hero->ctas as $cta)
                            <a href="{{ $cta->url }}" class="vb-btn vb-btn-{{ $cta->style ?? 'primary' }}">{{ $cta->label }}</a>
                        @endforeach
                    </div>
                @endif

                {{-- Social links --}}
                @if($socialLinks && $socialLinks->count())
                    <div class="vb-flex vb-gap-3" style="margin-top:48px;" data-gsap-stagger>
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="vb-footer-social-link" style="border-color:var(--vb-border-strong);" aria-label="{{ $link->platform }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Profile image with cinematic reveal --}}
            @if($hero?->profile_image)
                <div class="vb-hero-image" id="hero-image">
                    <div style="overflow:hidden;border:4px solid var(--vb-primary);position:relative;">
                        <img src="{{ \App\Helpers\ImageHelper::url($hero->profile_image, 'profile') }}" alt="{{ $hero->title }}" style="width:100%;height:100%;object-fit:cover;opacity:0;transform:scale(1.1);" id="hero-img">
                    </div>
                </div>
            @endif
        </div>

        {{-- Scroll indicator --}}
        <div style="position:absolute;bottom:32px;left:50%;transform:translateX(-50%);text-align:center;" data-gsap-reveal>
            <div style="width:24px;height:40px;border:2px solid var(--vb-border-strong);border-radius:12px;margin:0 auto 8px;position:relative;">
                <div style="width:4px;height:8px;background:var(--vb-secondary);border-radius:2px;position:absolute;top:8px;left:50%;transform:translateX(-50%);animation:scrollDot 1.5s ease-in-out infinite;"></div>
            </div>
            <span style="font-size:11px;text-transform:uppercase;letter-spacing:0.12em;color:var(--vb-text-tertiary);">Scroll</span>
        </div>
        <style>
            @keyframes scrollDot { 0%,100% { transform: translateX(-50%) translateY(0); opacity:1; } 50% { transform: translateX(-50%) translateY(12px); opacity:0.3; } }
        </style>
    </section>

    {{-- STATS BAR with counter animation --}}
    @if(isset($statistics) && $statistics->count())
    <section style="background:var(--vb-primary);border-top:4px solid var(--vb-secondary);border-bottom:4px solid var(--vb-secondary);overflow:hidden;">
        <div class="vb-container">
            <div class="vb-stats-bar" style="border:none;padding:48px 0;">
                @foreach($statistics as $stat)
                    <div style="text-align:center;" data-gsap-reveal>
                        <div class="vb-hero-stat-value">
                            <span class="vb-counter" data-target="{{ $stat->value }}">0</span><span style="font-size:0.6em;">{{ $stat->suffix }}</span>
                        </div>
                        <div class="vb-hero-stat-label" style="margin-top:8px;">{{ $stat->label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ABOUT with image reveal --}}
    @if($about)
    <section class="vb-section" id="about">
        <div class="vb-container">
            <div class="vb-about-grid">
                <div data-gsap-reveal>
                    <div class="vb-about-image">
                        @if($about->profile_image)
                            <div style="overflow:hidden;border:4px solid var(--vb-primary);">
                                <img src="{{ \App\Helpers\ImageHelper::url($about->profile_image, 'profile') }}" alt="{{ $about->title }}" style="width:100%;display:block;" class="vb-reveal-img">
                            </div>
                        @endif
                        @if($about->experience_years)
                            <div class="vb-about-image-badge" data-gsap-reveal>
                                <div style="font-size:24px;">{{ $about->experience_years }}+</div>
                                <div style="font-family:var(--vb-font-body);font-size:11px;text-transform:uppercase;letter-spacing:0.1em;">Years Experience</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <div style="overflow:hidden;" data-gsap-reveal>
                        <span class="overline" style="display:inline-block;transform:translateY(100%);">{{ $about->subtitle ?? 'About' }}</span>
                    </div>
                    <div style="overflow:hidden;" data-gsap-reveal>
                        <h2 style="display:inline-block;transform:translateY(100%);">{{ $about->title }}</h2>
                    </div>
                    <div style="overflow:hidden;" data-gsap-reveal>
                        <p style="font-size:20px;line-height:1.65;margin-bottom:24px;transform:translateY(100%);">{{ $about->description }}</p>
                    </div>
                    @if($about->highlights && count($about->highlights))
                        <div class="vb-about-highlights" data-gsap-stagger>
                            @foreach($about->highlights as $highlight)
                                <div class="vb-about-highlight">
                                    <span style="color:var(--vb-secondary);font-weight:700;font-size:16px;">&#10003;</span>
                                    {{ $highlight }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="vb-flex vb-gap-3" style="margin-top:24px;" data-gsap-reveal>
                        @if($about->cv_file)
                            <a href="{{ asset('storage/' . $about->cv_file) }}" class="vb-btn vb-btn-primary" target="_blank" download>Download CV</a>
                        @endif
                        @if($about->location)
                            <span style="display:flex;align-items:center;gap:8px;color:var(--vb-text-tertiary);font-size:14px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $about->location }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- SKILLS with bar animations --}}
    @if(isset($skills) && $skills->count())
    <section class="vb-section" id="skills" style="background:var(--vb-primary);color:var(--vb-tertiary);">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Skills</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);color:var(--vb-tertiary);">Technologies & Expertise</h2>
            </div>
            <div class="vb-skills-grid">
                @foreach($skills as $category)
                    <div class="vb-skill-card" style="border-color:#262626;background:#171717;" data-gsap-reveal>
                        <div class="vb-skill-header">
                            <span class="vb-skill-name" style="color:var(--vb-tertiary);">{{ $category->name }}</span>
                        </div>
                        @foreach($category->skills as $skill)
                            <div style="margin-bottom:12px;">
                                <div class="vb-flex vb-justify-between" style="margin-bottom:4px;">
                                    <span style="font-size:14px;color:#D4D4D4;">{{ $skill->name }}</span>
                                    @if($skill->percentage)
                                        <span class="vb-skill-pct" style="color:#A3A3A3;">{{ $skill->percentage }}%</span>
                                    @endif
                                </div>
                                @if($skill->percentage)
                                    <div class="vb-skill-bar" style="background:#262626;">
                                        <div class="vb-skill-bar-fill" style="width:0%;background:var(--vb-secondary);" data-width="{{ $skill->percentage }}%"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- PROJECTS with stagger reveal --}}
    @if(isset($projects) && $projects->count())
    <section class="vb-section" id="projects">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Portfolio</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);">Featured Projects</h2>
            </div>
            <div class="vb-grid vb-grid-3" data-gsap-stagger>
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="vb-project-card" data-gsap-hover>
                        @if($project->thumbnail)
                            <div class="vb-project-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" loading="lazy" class="vb-reveal-img">
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
                @endforeach
            </div>
            <div style="text-align:center;margin-top:48px;" data-gsap-reveal>
                <a href="{{ route('projects.index') }}" class="vb-btn vb-btn-secondary">View All Projects</a>
            </div>
        </div>
    </section>
    @endif

    {{-- SERVICES with stagger reveal --}}
    @if(isset($services) && $services->count())
    <section class="vb-section" id="services" style="background:var(--vb-surface);">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Services</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);">What I Offer</h2>
            </div>
            <div class="vb-services-grid" data-gsap-stagger>
                @foreach($services as $service)
                    <div class="vb-service-card" data-gsap-hover>
                        <div class="vb-service-icon" style="width:48px;height:48px;background:var(--vb-primary);color:var(--vb-tertiary);font-family:var(--vb-font-display);font-size:18px;display:flex;align-items:center;justify-content:center;">{{ strtoupper(substr($service->name, 0, 2)) }}</div>
                        <h3 class="vb-service-title">{{ $service->name }}</h3>
                        <p class="vb-service-desc">{{ Str::limit($service->description, 150) }}</p>
                        @if($service->features)
                            <div class="vb-service-features">
                                @foreach($service->features as $feature)
                                    <div class="vb-service-feature">
                                        <span style="color:var(--vb-secondary);font-weight:700;">&#10003;</span>
                                        {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- TESTIMONIALS --}}
    @if(isset($testimonials) && $testimonials->count())
    <section class="vb-section" id="testimonials">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Testimonials</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);">What Clients Say</h2>
            </div>
            <div class="vb-grid vb-grid-3" data-gsap-stagger>
                @foreach($testimonials as $testimonial)
                    <div class="vb-testimonial-card" data-gsap-hover>
                        <div class="vb-testimonial-quote">{{ $testimonial->content }}</div>
                        @if($testimonial->rating)
                            <div style="color:var(--vb-secondary);margin-bottom:12px;letter-spacing:2px;">
                                @for($i = 1; $i <= 5; $i++) &#9733; @endfor
                            </div>
                        @endif
                        <div class="vb-testimonial-name">{{ $testimonial->client_name }}</div>
                        @if($testimonial->client_position || $testimonial->client_company)
                            <div class="vb-testimonial-role">{{ $testimonial->client_position }}{{ $testimonial->client_company ? ' at ' . $testimonial->client_company : '' }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- EXPERIENCE TIMELINE --}}
    @if(isset($experiences) && $experiences->count())
    <section class="vb-section" id="experience">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Experience</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);">Work History</h2>
            </div>
            <div class="vb-timeline" data-gsap-stagger>
                @foreach($experiences as $exp)
                    <div class="vb-timeline-item {{ $exp->is_current ? 'current' : '' }}">
                        <div class="vb-timeline-dot" @if($exp->is_current) style="background:var(--vb-secondary);" @endif></div>
                        <div class="vb-timeline-date">{{ $exp->start_date->format('M Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : '') }}</div>
                        <h3 class="vb-timeline-title">{{ $exp->position }}</h3>
                        <div class="vb-timeline-company">{{ $exp->company }}{{ $exp->location ? ' · ' . $exp->location : '' }}</div>
                        @if($exp->description)<p class="vb-timeline-desc">{{ $exp->description }}</p>@endif
                        @if($exp->achievements && count($exp->achievements))
                            <ul style="margin-top:8px;padding-left:16px;">
                                @foreach($exp->achievements as $achievement)
                                    <li style="font-size:14px;color:var(--vb-text-secondary);margin-bottom:4px;">{{ $achievement }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- BLOG --}}
    @if(isset($posts) && $posts->count())
    <section class="vb-section" id="blog" style="background:var(--vb-surface);">
        <div class="vb-container">
            <div style="overflow:hidden;" data-gsap-reveal>
                <span class="overline" style="display:inline-block;transform:translateY(100%);">Blog</span>
            </div>
            <div style="overflow:hidden;margin-bottom:48px;" data-gsap-reveal>
                <h2 style="display:inline-block;transform:translateY(100%);">Latest Articles</h2>
            </div>
            <div class="vb-grid vb-grid-3" data-gsap-stagger>
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="vb-blog-card" data-gsap-hover>
                        @if($post->featured_image)
                            <div class="vb-blog-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" loading="lazy" class="vb-reveal-img">
                            </div>
                        @endif
                        <div class="vb-blog-body">
                            <div class="vb-blog-meta">
                                @if($post->category)<span>{{ $post->category->name }}</span>@endif
                                @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                                @if($post->reading_time)<span>{{ $post->reading_time }} min</span>@endif
                            </div>
                            <h3 class="vb-blog-title">{{ $post->name }}</h3>
                            <p class="vb-blog-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="text-align:center;margin-top:48px;" data-gsap-reveal>
                <a href="{{ route('blog.index') }}" class="vb-btn vb-btn-secondary">View All Articles</a>
            </div>
        </div>
    </section>
    @endif

    {{-- CONTACT --}}
    <section class="vb-section" id="contact" style="background:var(--vb-primary);color:var(--vb-tertiary);">
        <div class="vb-container">
            <div class="vb-contact-grid">
                <div>
                    <div style="overflow:hidden;" data-gsap-reveal>
                        <span class="overline" style="display:inline-block;transform:translateY(100%);">Contact</span>
                    </div>
                    <div style="overflow:hidden;margin-bottom:32px;" data-gsap-reveal>
                        <h2 style="display:inline-block;transform:translateY(100%);color:var(--vb-tertiary);">Get In Touch</h2>
                    </div>
                    @if($contact)
                        <div data-gsap-stagger>
                            @if($contact->email)
                                <div class="vb-contact-info-item">
                                    <div class="vb-contact-icon" style="border-color:var(--vb-secondary);color:var(--vb-secondary);">&#9993;</div>
                                    <div>
                                        <div class="vb-contact-label" style="color:#A3A3A3;">Email</div>
                                        <a href="mailto:{{ $contact->email }}" class="vb-contact-value" style="color:var(--vb-tertiary);">{{ $contact->email }}</a>
                                    </div>
                                </div>
                            @endif
                            @if($contact->phone)
                                <div class="vb-contact-info-item">
                                    <div class="vb-contact-icon" style="border-color:var(--vb-secondary);color:var(--vb-secondary);">&#9742;</div>
                                    <div>
                                        <div class="vb-contact-label" style="color:#A3A3A3;">Phone</div>
                                        <a href="tel:{{ $contact->phone }}" class="vb-contact-value" style="color:var(--vb-tertiary);">{{ $contact->phone }}</a>
                                    </div>
                                </div>
                            @endif
                            @if($contact->address)
                                <div class="vb-contact-info-item">
                                    <div class="vb-contact-icon" style="border-color:var(--vb-secondary);color:var(--vb-secondary);">&#9873;</div>
                                    <div>
                                        <div class="vb-contact-label" style="color:#A3A3A3;">Location</div>
                                        <span class="vb-contact-value" style="color:var(--vb-tertiary);">{{ $contact->address }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div data-gsap-reveal data-gsap-delay="0.3">
                    <form action="{{ route('contact.store') }}" method="POST" style="background:var(--vb-surface);padding:32px;border:2px solid #262626;">
                        @csrf
                        <div class="vb-grid vb-grid-2" style="gap:16px;">
                            <div><label class="vb-label">Name</label><input type="text" class="vb-input @error('name') error @enderror" name="name" value="{{ old('name') }}" required placeholder="Your name">@error('name') <p class="vb-error">{{ $message }}</p> @enderror</div>
                            <div><label class="vb-label">Email</label><input type="email" class="vb-input @error('email') error @enderror" name="email" value="{{ old('email') }}" required placeholder="your@email.com">@error('email') <p class="vb-error">{{ $message }}</p> @enderror</div>
                        </div>
                        <div style="margin-top:16px;"><label class="vb-label">Subject</label><input type="text" class="vb-input @error('subject') error @enderror" name="subject" value="{{ old('subject') }}" required placeholder="Subject">@error('subject') <p class="vb-error">{{ $message }}</p> @enderror</div>
                        <div style="margin-top:16px;"><label class="vb-label">Message</label><textarea class="vb-textarea @error('message') error @enderror" name="message" rows="5" required placeholder="Your message...">{{ old('message') }}</textarea>@error('message') <p class="vb-error">{{ $message }}</p> @enderror</div>
                        <button type="submit" class="vb-btn vb-btn-primary vb-btn-lg" style="width:100%;margin-top:16px;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@include('partials.vb-footer')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('vb-theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    const updateIcon = () => {
        const sun = document.querySelector('.icon-sun');
        const moon = document.querySelector('.icon-moon');
        if (sun && moon) { sun.style.display = savedTheme === 'dark' ? 'none' : 'block'; moon.style.display = savedTheme === 'dark' ? 'block' : 'none'; }
    };
    updateIcon();
    document.getElementById('vb-theme-toggle')?.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('vb-theme', next);
        updateIcon();
    });

    // Mobile menu
    const mt = document.getElementById('vb-mobile-toggle'), mm = document.getElementById('vb-mobile-menu'), mo = document.getElementById('vb-mobile-overlay'), mc = document.getElementById('vb-mobile-close');
    const openM = () => { mm?.classList.add('active'); mo?.classList.add('active'); document.body.style.overflow = 'hidden'; };
    const closeM = () => { mm?.classList.remove('active'); mo?.classList.remove('active'); document.body.style.overflow = ''; };
    mt?.addEventListener('click', () => mm?.classList.contains('active') ? closeM() : openM());
    mo?.addEventListener('click', closeM);
    mc?.addEventListener('click', closeM);

    // Header scroll
    const header = document.getElementById('vb-header');
    window.addEventListener('scroll', () => header?.classList.toggle('scrolled', window.scrollY > 50));

    // Rotating professions
    const professions = @json($hero?->professions?->pluck('profession') ?? []);
    const word = document.getElementById('vb-rotating-word');
    if (professions.length > 1 && word) {
        let idx = 0;
        setInterval(() => { idx = (idx + 1) % professions.length; word.style.opacity = '0'; setTimeout(() => { word.textContent = professions[idx]; word.style.opacity = '1'; }, 300); }, 3000);
    }

    // GSAP Animations
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Hero entrance timeline
        const heroTl = gsap.timeline({ delay: 0.3 });

        // Hero image reveal
        const heroImg = document.getElementById('hero-img');
        if (heroImg) {
            heroTl.to(heroImg, { opacity: 1, scale: 1, duration: 1.2, ease: 'power3.out' }, 0.5);
        }

        // Hero words reveal
        const heroWords = document.querySelectorAll('.hero-word');
        heroTl.to(heroWords, {
            y: 0, duration: 0.8, stagger: 0.08, ease: 'power3.out'
        }, 0.2);

        // Scroll-triggered reveals with text animation
        document.querySelectorAll('[data-gsap-reveal]').forEach(el => {
            const delay = parseFloat(el.dataset.gsapDelay) || 0;
            gsap.fromTo(el, { opacity: 0, y: 50 }, {
                opacity: 1, y: 0, duration: 0.9, delay, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 88%', once: true }
            });
        });

        // Stagger children
        document.querySelectorAll('[data-gsap-stagger]').forEach(container => {
            gsap.fromTo(container.children, { opacity: 0, y: 40 }, {
                opacity: 1, y: 0, duration: 0.7, stagger: 0.12, ease: 'power3.out',
                scrollTrigger: { trigger: container, start: 'top 88%', once: true }
            });
        });

        // Hover effects
        document.querySelectorAll('[data-gsap-hover]').forEach(el => {
            el.addEventListener('mouseenter', () => gsap.to(el, { y: -4, duration: 0.3, ease: 'power2.out' }));
            el.addEventListener('mouseleave', () => gsap.to(el, { y: 0, duration: 0.3, ease: 'power2.out' }));
        });

        // Skill bar animation
        document.querySelectorAll('.vb-skill-bar-fill').forEach(fill => {
            gsap.to(fill, {
                width: fill.dataset.width, duration: 1.5, ease: 'power2.out',
                scrollTrigger: { trigger: fill, start: 'top 92%', once: true }
            });
        });

        // Counter animation
        document.querySelectorAll('.vb-counter').forEach(counter => {
            const target = parseInt(counter.dataset.target);
            gsap.to(counter, {
                textContent: target, duration: 2.5, ease: 'power2.out',
                scrollTrigger: { trigger: counter, start: 'top 92%', once: true },
                onUpdate: function() { counter.textContent = Math.round(parseFloat(counter.textContent)); }
            });
        });

        // Hero parallax
        const heroImage = document.querySelector('.vb-hero-image img');
        if (heroImage) {
            gsap.to(heroImage, {
                y: 80, scale: 1.05,
                scrollTrigger: { trigger: '.vb-hero', start: 'top top', end: 'bottom top', scrub: 1.5 }
            });
        }

        // Section divider animations
        document.querySelectorAll('.vb-divider-strong').forEach(div => {
            gsap.fromTo(div, { scaleX: 0 }, {
                scaleX: 1, duration: 1, ease: 'power2.out',
                scrollTrigger: { trigger: div, start: 'top 90%', once: true }
            });
        });
    }
});
</script>
@endpush
@endsection
