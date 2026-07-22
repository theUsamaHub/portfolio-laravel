// ============================================
// VOICEBOX PORTFOLIO — FRONTEND JAVASCRIPT
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    initGSAP();
    initMobileNav();
    initRotatingText();
    initContactForm();
    initThemeToggle();
});

// === THEME TOGGLE ===
function initThemeToggle() {
    const toggle = document.getElementById('themeToggle');
    if (!toggle) return;

    // Load saved theme or default to light
    const saved = localStorage.getItem('vb-theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
    }

    toggle.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('vb-theme', next);
    });
}

// === GSAP SCROLL ANIMATIONS ===
function initGSAP() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    // Reveal animations — add gs-hidden class, then animate with GSAP
    document.querySelectorAll('[data-reveal]').forEach(el => {
        el.classList.add('gs-hidden');
        const direction = el.dataset.reveal || 'up';
        const delay = parseFloat(el.dataset.delay) || 0;

        let from = { opacity: 0, y: 50 };
        if (direction === 'left') from = { opacity: 0, x: -50 };
        if (direction === 'right') from = { opacity: 0, x: 50 };
        if (direction === 'scale') from = { opacity: 0, scale: 0.95 };

        gsap.fromTo(el, from, {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            duration: 1,
            delay,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 85%',
                toggleActions: 'play none none none',
            }
        });
    });

    // Stagger animations
    document.querySelectorAll('[data-stagger]').forEach(container => {
        const children = container.children;
        const direction = container.dataset.stagger || 'up';

        Array.from(children).forEach(child => child.classList.add('gs-hidden'));

        let from = { opacity: 0, y: 30 };
        if (direction === 'left') from = { opacity: 0, x: -30 };
        if (direction === 'scale') from = { opacity: 0, scale: 0.95 };

        gsap.fromTo(children, from, {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            duration: 0.8,
            stagger: 0.15,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: container,
                start: 'top 80%',
                toggleActions: 'play none none none',
            }
        });
    });

    // Counter animation
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count);
        const suffix = el.dataset.suffix || '';

        if (isNaN(target)) return;

        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: 2,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 85%',
                toggleActions: 'play none none none',
            },
            onUpdate: function() {
                el.textContent = Math.round(obj.val) + suffix;
            }
        });
    });

    // Skill bar animations
    document.querySelectorAll('.vb-skill-item__bar-fill').forEach(bar => {
        const width = bar.dataset.width || '0%';
        gsap.from(bar, {
            width: '0%',
            duration: 1.2,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: bar,
                start: 'top 90%',
                toggleActions: 'play none none none',
            }
        });
    });

    // Parallax
    document.querySelectorAll('[data-parallax]').forEach(el => {
        const speed = parseFloat(el.dataset.parallax) || 0.2;
        gsap.to(el, {
            y: () => -100 * speed,
            ease: 'none',
            scrollTrigger: {
                trigger: el,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            }
        });
    });

    // ─── ZOOM EFFECTS ───────────────────────────────

    // Hero zoom on scroll — subtle scale shift as user scrolls past
    const hero = document.querySelector('.vb-hero');
    if (hero) {
        gsap.to('.vb-hero__content', {
            scale: 1.03,
            ease: 'none',
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: 1,
            }
        });
        gsap.to('.vb-hero__visual', {
            scale: 0.97,
            ease: 'none',
            scrollTrigger: {
                trigger: hero,
                start: '30% top',
                end: 'bottom top',
                scrub: 1,
            }
        });
    }

    // Section zoom-in on enter — each section scales from 0.96 to 1
    document.querySelectorAll('.vb-section').forEach(section => {
        gsap.fromTo(section,
            { scale: 0.96, opacity: 0.7 },
            {
                scale: 1,
                opacity: 1,
                duration: 1,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    end: 'top 40%',
                    scrub: 1,
                }
            }
        );
    });

    // Image zoom on scroll — project images, about image scale up as they enter
    document.querySelectorAll('.vb-project__image img, .vb-about__image img, .vb-post__image img').forEach(img => {
        gsap.fromTo(img,
            { scale: 1.15 },
            {
                scale: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: img,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                }
            }
        );
    });

    // Section header zoom-pop — headers scale from 0.9 to 1 with opacity
    document.querySelectorAll('.vb-section__header').forEach(header => {
        gsap.fromTo(header,
            { scale: 0.9, opacity: 0 },
            {
                scale: 1,
                opacity: 1,
                duration: 0.8,
                ease: 'back.out(1.4)',
                scrollTrigger: {
                    trigger: header,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                }
            }
        );
    });

    // Stats number zoom-pop
    document.querySelectorAll('[data-count]').forEach(el => {
        gsap.fromTo(el,
            { scale: 0.5, opacity: 0 },
            {
                scale: 1,
                opacity: 1,
                duration: 0.6,
                ease: 'back.out(2)',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                }
            }
        );
    });

    // Skill category cards zoom-in stagger
    document.querySelectorAll('.vb-skill-category').forEach((card, i) => {
        gsap.fromTo(card,
            { scale: 0.9, opacity: 0, y: 30 },
            {
                scale: 1,
                opacity: 1,
                y: 0,
                duration: 0.6,
                delay: i * 0.15,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                }
            }
        );
    });
}

// === MOBILE NAVIGATION ===
function initMobileNav() {
    const toggle = document.querySelector('.vb-nav__toggle');
    const mobile = document.querySelector('.vb-nav__mobile');

    if (!toggle || !mobile) return;

    toggle.addEventListener('click', () => {
        mobile.classList.toggle('is-open');
        toggle.classList.toggle('is-active');

        const spans = toggle.querySelectorAll('span');
        if (mobile.classList.contains('is-open')) {
            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
        } else {
            spans[0].style.transform = '';
            spans[1].style.opacity = '';
            spans[2].style.transform = '';
        }
    });

    mobile.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobile.classList.remove('is-open');
            toggle.classList.remove('is-active');
            const spans = toggle.querySelectorAll('span');
            spans[0].style.transform = '';
            spans[1].style.opacity = '';
            spans[2].style.transform = '';
        });
    });
}

// === ROTATING TEXT ===
function initRotatingText() {
    const container = document.querySelector('[data-rotate]');
    if (!container) return;

    const items = container.querySelectorAll('[data-rotate-item]');
    if (items.length === 0) return;

    let current = 0;
    items[0].classList.add('is-active');

    setInterval(() => {
        items[current].classList.remove('is-active');
        current = (current + 1) % items.length;
        items[current].classList.add('is-active');
    }, 3000);
}

// === CONTACT FORM ===
function initContactForm() {
    const form = document.querySelector('#contactForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.textContent;
        btn.textContent = 'SENDING...';
        btn.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.ok) {
                btn.textContent = 'SENT!';
                form.reset();
                setTimeout(() => { btn.textContent = originalText; btn.disabled = false; }, 3000);
            } else {
                btn.textContent = 'ERROR';
                setTimeout(() => { btn.textContent = originalText; btn.disabled = false; }, 3000);
            }
        } catch {
            btn.textContent = 'ERROR';
            setTimeout(() => { btn.textContent = originalText; btn.disabled = false; }, 3000);
        }
    });
}
