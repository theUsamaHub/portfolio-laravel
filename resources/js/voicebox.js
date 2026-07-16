// VoiceBox GSAP Animations
document.addEventListener('DOMContentLoaded', () => {
    // Register ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // Theme toggle
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('vbox-theme') || 'light';
    applyTheme(savedTheme);

    document.getElementById('vbox-theme-toggle')?.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        localStorage.setItem('vbox-theme', next);
    });

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        if (theme === 'dark') {
            document.documentElement.style.setProperty('--vbox-bg', '#0A0A0A');
            document.documentElement.style.setProperty('--vbox-surface', '#1A1A1A');
            document.documentElement.style.setProperty('--vbox-text', '#FAFAFA');
            document.documentElement.style.setProperty('--vbox-border', '#333');
        } else {
            document.documentElement.style.setProperty('--vbox-bg', '#FAFAFA');
            document.documentElement.style.setProperty('--vbox-surface', '#F5F5F5');
            document.documentElement.style.setProperty('--vbox-text', '#0A0A0A');
            document.documentElement.style.setProperty('--vbox-border', '#E5E5E5');
        }
    }

    // Mobile menu
    const mobileToggle = document.getElementById('vbox-mobile-toggle');
    const mobileMenu = document.getElementById('vbox-mobile-menu');
    const mobileOverlay = document.getElementById('vbox-mobile-overlay');
    const mobileClose = document.getElementById('vbox-mobile-close');

    function openMobile() {
        mobileMenu?.classList.add('active');
        mobileOverlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeMobile() {
        mobileMenu?.classList.remove('active');
        mobileOverlay?.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileToggle?.addEventListener('click', openMobile);
    mobileOverlay?.addEventListener('click', closeMobile);
    mobileClose?.addEventListener('click', closeMobile);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMobile();
    });

    // Header scroll effect
    const header = document.getElementById('vbox-header');
    window.addEventListener('scroll', () => {
        header?.classList.toggle('scrolled', window.scrollY > 50);
    });

    // GSAP Animations
    // Hero title reveal
    gsap.from('.vbox-hero-title', {
        y: 80, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.2
    });

    gsap.from('.vbox-hero-overline', {
        y: 30, opacity: 0, duration: 0.8, ease: 'power3.out', delay: 0.4
    });

    gsap.from('.vbox-hero-subtitle', {
        y: 30, opacity: 0, duration: 0.8, ease: 'power3.out', delay: 0.6
    });

    gsap.from('.vbox-hero-cta', {
        y: 30, opacity: 0, duration: 0.8, ease: 'power3.out', delay: 0.8
    });

    gsap.from('.vbox-hero-image', {
        x: 80, opacity: 0, duration: 1.2, ease: 'power3.out', delay: 0.5
    });

    // Scroll-triggered reveals
    gsap.utils.toArray('.vbox-reveal').forEach(el => {
        gsap.to(el, {
            scrollTrigger: { trigger: el, start: 'top 85%', once: true },
            y: 0, opacity: 1, duration: 0.8, ease: 'power3.out'
        });
    });

    gsap.utils.toArray('.vbox-reveal-left').forEach(el => {
        gsap.to(el, {
            scrollTrigger: { trigger: el, start: 'top 85%', once: true },
            x: 0, opacity: 1, duration: 0.8, ease: 'power3.out'
        });
    });

    gsap.utils.toArray('.vbox-reveal-right').forEach(el => {
        gsap.to(el, {
            scrollTrigger: { trigger: el, start: 'top 85%', once: true },
            x: 0, opacity: 1, duration: 0.8, ease: 'power3.out'
        });
    });

    gsap.utils.toArray('.vbox-reveal-scale').forEach(el => {
        gsap.to(el, {
            scrollTrigger: { trigger: el, start: 'top 85%', once: true },
            scale: 1, opacity: 1, duration: 0.8, ease: 'power3.out'
        });
    });

    // Stagger children
    gsap.utils.toArray('.vbox-stagger').forEach(container => {
        const children = container.querySelectorAll('.vbox-stagger-child');
        gsap.to(children, {
            scrollTrigger: { trigger: container, start: 'top 80%', once: true },
            y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: 'power3.out'
        });
    });

    // Skill bar animations
    gsap.utils.toArray('.vbox-skill-fill').forEach(bar => {
        const width = bar.dataset.width || '0%';
        gsap.to(bar, {
            scrollTrigger: { trigger: bar, start: 'top 90%', once: true },
            width: width, duration: 1.2, ease: 'power3.out'
        });
    });

    // Counter animations
    gsap.utils.toArray('.vbox-counter').forEach(counter => {
        const target = parseInt(counter.dataset.target) || 0;
        const suffix = counter.dataset.suffix || '';
        gsap.fromTo(counter, { innerText: 0 }, {
            scrollTrigger: { trigger: counter, start: 'top 90%', once: true },
            innerText: target, duration: 2, ease: 'power2.out',
            snap: { innerText: 1 },
            onUpdate: function() { counter.innerText = Math.round(counter.innerText) + suffix; }
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                closeMobile();
                gsap.to(window, { scrollTo: { y: target, offsetY: 80 }, duration: 1, ease: 'power3.inOut' });
            }
        });
    });

    // Magnetic hover effect on buttons
    document.querySelectorAll('.vbox-btn').forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(btn, { x: x * 0.15, y: y * 0.15, duration: 0.3, ease: 'power2.out' });
        });
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { x: 0, y: 0, duration: 0.3, ease: 'power2.out' });
        });
    });

    // Parallax on hero image
    const heroImage = document.querySelector('.vbox-hero-image');
    if (heroImage) {
        gsap.to(heroImage, {
            scrollTrigger: { trigger: '.vbox-hero', start: 'top top', end: 'bottom top', scrub: 1 },
            y: -80, ease: 'none'
        });
    }

    // Reduced motion check
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        ScrollTrigger.getAll().forEach(st => st.kill());
        gsap.globalTimeline.clear();
        document.querySelectorAll('.vbox-reveal, .vbox-reveal-left, .vbox-reveal-right, .vbox-reveal-scale, .vbox-stagger-child').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
    }
});
