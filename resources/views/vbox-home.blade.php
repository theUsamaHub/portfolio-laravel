@extends('layouts.voicebox')
@section('content')
@include('partials.vbox-header')

<main id="main-content">
    {{-- HERO --}}
    @if($hero)
    <section class="vbox-hero" id="hero">
        @if($hero->background_video)
            <div class="vbox-hero-bg">
                <video autoplay muted loop playsinline><source src="{{ asset('storage/'.$hero->background_video) }}" type="video/mp4"></video>
            </div>
        @elseif($hero->background_image)
            <div class="vbox-hero-bg"><img src="{{ \App\Helpers\ImageHelper::url($hero->background_image, 'hero-bg') }}" alt="" loading="eager"></div>
        @endif
        <div class="vbox-container vbox-hero-content">
            <p class="vbox-hero-overline">{{ $hero->subtitle ?? 'Portfolio' }}</p>
            <h1 class="vbox-hero-title">{!! nl2br(e($hero->title)) !!}</h1>
            @if($hero->description)
                <p class="vbox-hero-subtitle">{{ $hero->description }}</p>
            @endif
            @if($hero->professions->count())
                <p class="vbox-body-lg" style="margin-bottom:2rem;">
                    I'm a <span class="vbox-text-red vbox-accent-underline" id="vbox-rotating-word">{{ $hero->professions->first()->profession }}</span>
                </p>
            @endif
            @if($hero->ctas->count())
                <div class="vbox-hero-cta">
                    @foreach($hero->ctas as $cta)
                        <a href="{{ $cta->url }}" class="vbox-btn vbox-btn-{{ $cta->style === 'outline' ? 'secondary' : ($cta->style ?? 'primary') }}">{{ $cta->label }}</a>
                    @endforeach
                </div>
            @endif
        </div>
        @if($hero->profile_image)
            <div class="vbox-hero-image">
                <img src="{{ \App\Helpers\ImageHelper::url($hero->profile_image, 'profile') }}" alt="{{ $hero->title }}" loading="eager">
            </div>
        @endif
    </section>
    @endif

    {{-- STATISTICS --}}
    @if(isset($statistics) && $statistics->count())
    <section class="vbox-section vbox-border-bottom" style="background: var(--vbox-bg, #FAFAFA);">
        <div class="vbox-container">
            <div class="vbox-stagger" style="display:grid;grid-template-columns:repeat(2,1fr);gap:0;border:1px solid var(--vbox-border,#E5E5E5);">
                @foreach($statistics as $stat)
                    <div style="padding:2rem;text-align:center;{{ !$loop->last ? 'border-right:1px solid var(--vbox-border,#E5E5E5);' : '' }}{{ $loop->index > 1 ? 'border-top:1px solid var(--vbox-border,#E5E5E5);' : '' }}" class="vbox-stagger-child">
                        <div class="vbox-counter vbox-stat-value" data-target="{{ $stat->value }}" data-suffix="{{ $stat->suffix ?? '' }}">0{{ $stat->suffix ?? '' }}</div>
                        <div class="vbox-stat-label">{{ $stat->label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ABOUT --}}
    @if($about)
    <section class="vbox-section" id="about">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">{{ $about->subtitle ?? 'About' }}</p>
                <h2 class="vbox-section-title">{{ $about->title }}</h2>
            </div>
            <div class="vbox-about-grid">
                <div class="vbox-reveal-left">
                    @if($about->profile_image)
                        <div class="vbox-about-image">
                            <img src="{{ \App\Helpers\ImageHelper::url($about->profile_image, 'profile') }}" alt="{{ $about->title }}">
                        </div>
                    @endif
                    @if($about->experience_years)
                        <div class="vbox-about-stats">
                            <div>
                                <div class="vbox-counter vbox-stat-value" data-target="{{ $about->experience_years }}" data-suffix="+">0+</div>
                                <div class="vbox-stat-label">Years Experience</div>
                            </div>
                            @if($about->location)
                                <div>
                                    <div class="vbox-body-sm vbox-text-secondary">{{ $about->location }}</div>
                                    <div class="vbox-stat-label">Based In</div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="vbox-reveal-right">
                    <p class="vbox-body-lg" style="margin-bottom:1.5rem;">{{ $about->description }}</p>
                    @if($about->highlights && count($about->highlights))
                        <div style="margin-bottom:1.5rem;">
                            @foreach($about->highlights as $highlight)
                                <div style="display:flex;align-items:center;gap:0.75rem;padding:0.5rem 0;border-bottom:1px solid var(--vbox-border-subtle,#E5E5E5);">
                                    <span style="color:var(--vbox-red,#EF4444);font-weight:700;">&rarr;</span>
                                    <span class="vbox-body-sm">{{ $highlight }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($about->cv_file)
                        <a href="{{ asset('storage/' . $about->cv_file) }}" class="vbox-btn vbox-btn-secondary" target="_blank" download>Download CV</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- SKILLS --}}
    @if(isset($skills) && $skills->count())
    <section class="vbox-section vbox-border-top vbox-border-bottom" style="background:var(--vbox-bg,#FAFAFA);" id="skills">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Expertise</p>
                <h2 class="vbox-section-title">Skills & Technologies</h2>
            </div>
            <div class="vbox-skills-grid">
                @foreach($skills as $category)
                    <div class="vbox-skill-item vbox-stagger-child">
                        <p class="vbox-overline vbox-text-red">{{ $category->name }}</p>
                        @foreach($category->skills as $skill)
                            <div style="margin-bottom:1rem;">
                                <div class="flex justify-between items-center" style="margin-bottom:0.25rem;">
                                    <span class="vbox-body-sm" style="font-weight:600;">{{ $skill->name }}</span>
                                    @if($skill->percentage)
                                        <span class="vbox-caption">{{ $skill->percentage }}%</span>
                                    @endif
                                </div>
                                @if($skill->percentage)
                                    <div class="vbox-skill-bar">
                                        <div class="vbox-skill-fill" data-width="{{ $skill->percentage }}%" style="width:0%"></div>
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

    {{-- PROJECTS --}}
    @if(isset($projects) && $projects->count())
    <section class="vbox-section" id="projects">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Work</p>
                <h2 class="vbox-section-title">Featured Projects</h2>
            </div>
            <div class="vbox-projects-grid">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="vbox-project-card vbox-stagger-child">
                        @if($project->thumbnail)
                            <div class="vbox-project-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($project->thumbnail, 'project') }}" alt="{{ $project->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vbox-project-body">
                            @if($project->category)
                                <span class="vbox-project-category">{{ $project->category->name }}</span>
                            @endif
                            <h3 class="vbox-project-title">{{ $project->name }}</h3>
                            <p class="vbox-project-desc">{{ $project->short_description ?? Str::limit(strip_tags($project->description), 120) }}</p>
                            @if($project->technologies->count())
                                <div class="vbox-project-tech">
                                    @foreach($project->technologies->take(4) as $tech)
                                        <span class="vbox-tech-tag">{{ $tech->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="vbox-project-links">
                                <span class="vbox-btn vbox-btn-ghost vbox-btn-sm">View Project &rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="vbox-reveal" style="margin-top:2rem;text-align:center;">
                <a href="{{ route('projects.index') }}" class="vbox-btn vbox-btn-secondary">All Projects</a>
            </div>
        </div>
    </section>
    @endif

    {{-- SERVICES --}}
    @if(isset($services) && $services->count())
    <section class="vbox-section vbox-border-top" style="background:var(--vbox-bg,#FAFAFA);" id="services">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">What I Do</p>
                <h2 class="vbox-section-title">Services</h2>
            </div>
            <div class="vbox-services-grid">
                @foreach($services as $service)
                    <div class="vbox-service-card vbox-stagger-child">
                        @if($service->icon)
                            <div class="vbox-service-icon">{!! $service->icon !!}</div>
                        @endif
                        <h3 class="vbox-service-title">{{ $service->name }}</h3>
                        <p class="vbox-service-desc">{{ Str::limit($service->description, 150) }}</p>
                        @if($service->features && count($service->features))
                            <div style="text-align:left;margin-top:1rem;">
                                @foreach($service->features as $feature)
                                    <div style="display:flex;align-items:center;gap:0.5rem;padding:0.375rem 0;font-size:0.875rem;border-bottom:1px solid var(--vbox-border-subtle,#E5E5E5);">
                                        <span style="color:var(--vbox-red,#EF4444);font-weight:700;">&rarr;</span> {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if($service->price)
                            <div class="vbox-service-price">${{ $service->price }}<span style="font-size:0.875rem;font-weight:400;color:var(--vbox-text-tertiary,#A3A3A3);">/{{ $service->price_unit ?? 'project' }}</span></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- TESTIMONIALS --}}
    @if(isset($testimonials) && $testimonials->count())
    <section class="vbox-section vbox-border-top" id="testimonials">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Testimonials</p>
                <h2 class="vbox-section-title">What Clients Say</h2>
            </div>
            <div class="vbox-testimonials-grid">
                @foreach($testimonials as $testimonial)
                    <div class="vbox-testimonial-card vbox-stagger-child">
                        <blockquote class="vbox-testimonial-quote">{{ $testimonial->content }}</blockquote>
                        <p class="vbox-testimonial-name">{{ $testimonial->client_name }}</p>
                        @if($testimonial->client_position || $testimonial->client_company)
                            <p class="vbox-testimonial-role">{{ $testimonial->client_position }}{{ $testimonial->client_company ? ' at ' . $testimonial->client_company : '' }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- BLOG --}}
    @if(isset($posts) && $posts->count())
    <section class="vbox-section vbox-border-top" style="background:var(--vbox-bg,#FAFAFA);" id="blog">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Writing</p>
                <h2 class="vbox-section-title">Latest Articles</h2>
            </div>
            <div class="vbox-blog-grid">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="vbox-blog-card vbox-stagger-child">
                        @if($post->featured_image)
                            <div class="vbox-blog-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vbox-blog-body">
                            <div class="vbox-blog-meta">
                                @if($post->category)<span>{{ $post->category->name }}</span>@endif
                                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                                @if($post->reading_time)<span>{{ $post->reading_time }} min</span>@endif
                            </div>
                            <h3 class="vbox-blog-title">{{ $post->name }}</h3>
                            <p class="vbox-blog-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="vbox-reveal" style="margin-top:2rem;text-align:center;">
                <a href="{{ route('blog.index') }}" class="vbox-btn vbox-btn-secondary">All Articles</a>
            </div>
        </div>
    </section>
    @endif

    {{-- CONTACT --}}
    <section class="vbox-section vbox-border-top" id="contact">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Get In Touch</p>
                <h2 class="vbox-section-title">Contact</h2>
            </div>
            <div class="vbox-contact-grid">
                <div class="vbox-contact-info vbox-reveal-left">
                    @if($contact)
                        @if($contact->email)
                            <div class="vbox-contact-item">
                                <div><p class="vbox-contact-label">Email</p><p class="vbox-contact-value">{{ $contact->email }}</p></div>
                            </div>
                        @endif
                        @if($contact->phone)
                            <div class="vbox-contact-item">
                                <div><p class="vbox-contact-label">Phone</p><p class="vbox-contact-value">{{ $contact->phone }}</p></div>
                            </div>
                        @endif
                        @if($contact->address)
                            <div class="vbox-contact-item">
                                <div><p class="vbox-contact-label">Location</p><p class="vbox-contact-value">{{ $contact->address }}{{ $contact->city ? ', ' . $contact->city : '' }}</p></div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="vbox-contact-form vbox-reveal-right">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="vbox-form-row">
                            <div class="vbox-form-group">
                                <label class="vbox-label" for="name">Name</label>
                                <input type="text" class="vbox-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Your name">
                                @error('name') <p class="vbox-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="vbox-form-group">
                                <label class="vbox-label" for="email">Email</label>
                                <input type="email" class="vbox-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                                @error('email') <p class="vbox-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="vbox-form-group">
                            <label class="vbox-label" for="subject">Subject</label>
                            <input type="text" class="vbox-input @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="How can I help you?">
                            @error('subject') <p class="vbox-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="vbox-form-group">
                            <label class="vbox-label" for="message">Message</label>
                            <textarea class="vbox-textarea @error('message') is-invalid @enderror" id="message" name="message" rows="5" required placeholder="Your message...">{{ old('message') }}</textarea>
                            @error('message') <p class="vbox-error">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="vbox-btn vbox-btn-primary vbox-btn-lg" style="width:100%;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@include('partials.vbox-footer')
@endsection
