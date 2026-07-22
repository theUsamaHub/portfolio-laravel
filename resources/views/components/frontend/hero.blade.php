@props(['hero', 'settings', 'socialLinks', 'statistics'])

<section class="vb-hero" id="hero">
    <div class="vb-hero__bg">
        <div class="vb-hero__grid"></div>
        <canvas class="vb-hero__canvas" id="heroCanvas"></canvas>
    </div>

    <div class="vb-hero__container">
        <div class="vb-hero__content">
            <div class="vb-hero__eyebrow" data-reveal="left">
                <span class="vb-hero__eyebrow-dot"></span>
                Available for work
            </div>

            <h1 class="vb-hero__title" data-reveal>
                <span class="vb-hero__subtitle-line">{{ $hero->subtitle ?? 'Hello, I\'m' }}</span>
                <span class="vb-hero__title-accent">{{ $hero->title ?? 'Usama' }}</span>
            </h1>

            @if($hero->professions->count())
                <div class="vb-hero__typing" data-reveal data-delay="0.15">
                    <span class="vb-hero__typing-label">I'm a</span>
                    <span class="vb-hero__typing-text" id="typingText"></span>
                    <span class="vb-hero__typing-cursor">|</span>
                </div>
            @endif

            @if($hero->description)
                <p class="vb-hero__subtitle" data-reveal data-delay="0.2">{{ $hero->description }}</p>
            @endif

            <div class="vb-hero__actions" data-reveal data-delay="0.3">
                @foreach($hero->ctas->where('is_active', true)->sortBy('sort_order') as $cta)
                    <a href="{{ $cta->url }}"
                       class="vb-btn {{ $cta->style === 'primary' ? 'vb-btn--primary' : '' }} magnetic"
                       @if($cta->style !== 'primary') style="border-color: var(--vb-black);" @endif
                       data-cursor>
                        {{ $cta->label }}
                    </a>
                @endforeach
            </div>

            <div class="vb-hero__bottom-row" data-reveal data-delay="0.4">
                @if($hero->resume_file)
                    <a href="{{ Storage::url($hero->resume_file) }}" class="vb-btn vb-btn--ghost" target="_blank" data-cursor>
                        Download CV →
                    </a>
                @endif
                @if($statistics->count())
                    <div class="vb-hero__stats-mini">
                        @foreach($statistics->take(3) as $stat)
                            <div class="vb-hero__stat-mini">
                                <span class="vb-hero__stat-num">{{ $stat->value }}{{ $stat->suffix }}</span>
                                <span class="vb-hero__stat-lbl">{{ $stat->label }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($socialLinks->count())
                <div class="vb-hero__social-row" data-reveal data-delay="0.5">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="vb-hero__social-pill" data-cursor>
                            @if($link->platform === 'GitHub')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                            @elseif($link->platform === 'LinkedIn')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            @elseif($link->platform === 'Twitter')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            @else
                                <span style="font-size:0.6rem;font-weight:700;">{{ strtoupper(substr($link->platform, 0, 2)) }}</span>
                            @endif
                            {{ $link->platform }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="vb-hero__visual" data-reveal="right" data-delay="0.3">
            <div class="vb-hero__image-wrap">
                @if($hero->profile_image)
                    <img src="{{ Storage::url($hero->profile_image) }}" alt="{{ $hero->title }}" class="vb-hero__image" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="vb-hero__image-placeholder" style="display:none;"><span>{{ strtoupper(substr($hero->title ?? 'U', 0, 1)) }}</span></div>
                @else
                    <div class="vb-hero__image-placeholder"><span>{{ strtoupper(substr($hero->title ?? 'U', 0, 1)) }}</span></div>
                @endif
                <div class="vb-hero__image-border"></div>
                <div class="vb-hero__corner vb-hero__corner--tl"></div>
                <div class="vb-hero__corner vb-hero__corner--tr"></div>
                <div class="vb-hero__corner vb-hero__corner--bl"></div>
                <div class="vb-hero__corner vb-hero__corner--br"></div>
            </div>
        </div>
    </div>

    <div class="vb-hero__scroll">
        <span class="vb-hero__scroll-text">Scroll</span>
        <div class="vb-hero__scroll-line"></div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ─── Typewriter Effect ─────────────────────────
    const typingEl = document.getElementById('typingText');
    const professions = {!! json_encode($hero->professions->sortBy('sort_order')->pluck('profession')->toArray()) !!};

    if (typingEl && professions.length > 0) {
        let profIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let isPaused = false;

        function typeLoop() {
            const current = professions[profIndex];

            if (isPaused) {
                isPaused = false;
                isDeleting = true;
                setTimeout(typeLoop, 50);
                return;
            }

            if (!isDeleting) {
                typingEl.textContent = current.substring(0, charIndex + 1);
                charIndex++;

                if (charIndex === current.length) {
                    isPaused = true;
                    setTimeout(typeLoop, 2000);
                    return;
                }
                setTimeout(typeLoop, 80 + Math.random() * 40);
            } else {
                typingEl.textContent = current.substring(0, charIndex - 1);
                charIndex--;

                if (charIndex === 0) {
                    isDeleting = false;
                    profIndex = (profIndex + 1) % professions.length;
                    setTimeout(typeLoop, 400);
                    return;
                }
                setTimeout(typeLoop, 40);
            }
        }
        setTimeout(typeLoop, 800);
    }

    // ─── Three.js Enhanced Scene ────────────────────
    const canvas = document.getElementById('heroCanvas');
    if (!canvas || typeof THREE === 'undefined') return;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // ─── Main icosahedron (hero piece) ──────────────
    const icoGeo = new THREE.IcosahedronGeometry(1.6, 1);
    const icoMat = new THREE.MeshPhongMaterial({
        color: 0xEF4444, wireframe: true, transparent: true, opacity: 0.6,
        shininess: 100
    });
    const ico = new THREE.Mesh(icoGeo, icoMat);
    ico.position.set(-3.5, 1.8, -2);
    scene.add(ico);

    // Inner solid icosahedron
    const icoInner = new THREE.Mesh(
        new THREE.IcosahedronGeometry(1.0, 0),
        new THREE.MeshPhongMaterial({ color: 0xEF4444, transparent: true, opacity: 0.08 })
    );
    icoInner.position.copy(ico.position);
    scene.add(icoInner);

    // ─── Octahedron cluster ─────────────────────────
    const octGeo = new THREE.OctahedronGeometry(0.7, 0);
    const octMat = new THREE.MeshPhongMaterial({ color: 0x0A0A0A, wireframe: true, transparent: true, opacity: 0.4 });
    const oct = new THREE.Mesh(octGeo, octMat);
    oct.position.set(-4.5, -1.2, -3.5);
    scene.add(oct);

    const oct2 = new THREE.Mesh(
        new THREE.OctahedronGeometry(0.4, 0),
        new THREE.MeshPhongMaterial({ color: 0xEF4444, wireframe: true, transparent: true, opacity: 0.3 })
    );
    oct2.position.set(-3.8, -0.8, -4.5);
    scene.add(oct2);

    // ─── Torus ring ─────────────────────────────────
    const torusGeo = new THREE.TorusGeometry(0.8, 0.2, 16, 32);
    const torusMat = new THREE.MeshPhongMaterial({ color: 0xEF4444, wireframe: true, transparent: true, opacity: 0.5 });
    const torus = new THREE.Mesh(torusGeo, torusMat);
    torus.position.set(-1.5, -0.3, -4);
    scene.add(torus);

    // ─── Distant subtle shapes ──────────────────────
    const dod = new THREE.Mesh(
        new THREE.DodecahedronGeometry(0.5, 0),
        new THREE.MeshPhongMaterial({ color: 0xA3A3A3, wireframe: true, transparent: true, opacity: 0.2 })
    );
    dod.position.set(4, 2.5, -7);
    scene.add(dod);

    const ring2 = new THREE.Mesh(
        new THREE.TorusGeometry(0.4, 0.06, 8, 32),
        new THREE.MeshPhongMaterial({ color: 0xE5E5E5, wireframe: true, transparent: true, opacity: 0.15 })
    );
    ring2.position.set(4.5, -1.8, -8);
    scene.add(ring2);

    // ─── Particle field ─────────────────────────────
    const pGeo = new THREE.BufferGeometry();
    const pCount = 120;
    const pPos = new Float32Array(pCount * 3);
    for (let i = 0; i < pCount * 3; i++) pPos[i] = (Math.random() - 0.5) * 16;
    pGeo.setAttribute('position', new THREE.BufferAttribute(pPos, 3));
    const pMat = new THREE.PointsMaterial({ size: 0.012, color: 0xEF4444, transparent: true, opacity: 0.4 });
    const particles = new THREE.Points(pGeo, pMat);
    scene.add(particles);

    // ─── Connecting lines (particle constellation) ──
    const lineGeo = new THREE.BufferGeometry();
    const linePositions = new Float32Array(30 * 3);
    for (let i = 0; i < 30; i++) {
        linePositions[i * 3] = (Math.random() - 0.5) * 8 - 3;
        linePositions[i * 3 + 1] = (Math.random() - 0.5) * 6;
        linePositions[i * 3 + 2] = (Math.random() - 0.5) * 4 - 3;
    }
    lineGeo.setAttribute('position', new THREE.BufferAttribute(linePositions, 3));
    const lineMat = new THREE.LineBasicMaterial({ color: 0xEF4444, transparent: true, opacity: 0.08 });
    const lines = new THREE.LineSegments(lineGeo, lineMat);
    scene.add(lines);

    // ─── Lights ─────────────────────────────────────
    scene.add(new THREE.AmbientLight(0xffffff, 0.35));
    const pl1 = new THREE.PointLight(0xEF4444, 1.2, 25);
    pl1.position.set(-4, 3, 2);
    scene.add(pl1);
    const pl2 = new THREE.PointLight(0xffffff, 0.4, 20);
    pl2.position.set(3, -2, 1);
    scene.add(pl2);

    camera.position.z = 6;

    let mx = 0, my = 0;
    document.addEventListener('mousemove', (e) => {
        mx = (e.clientX / window.innerWidth) * 2 - 1;
        my = -(e.clientY / window.innerHeight) * 2 + 1;
    });

    function animate() {
        requestAnimationFrame(animate);
        const t = Date.now() * 0.001;

        ico.rotation.x += 0.003;
        ico.rotation.y += 0.005;
        ico.position.y = 1.8 + Math.sin(t * 0.4) * 0.35;
        icoInner.rotation.x -= 0.002;
        icoInner.rotation.y -= 0.003;
        icoInner.position.copy(ico.position);

        oct.rotation.x += 0.005;
        oct.rotation.z += 0.003;
        oct.position.y = -1.2 + Math.cos(t * 0.6) * 0.25;

        oct2.rotation.y += 0.006;
        oct2.position.y = -0.8 + Math.sin(t * 0.7) * 0.2;

        torus.rotation.x += 0.003;
        torus.rotation.y += 0.006;
        torus.position.y = -0.3 + Math.sin(t * 0.5) * 0.2;

        dod.rotation.y += 0.003;
        dod.position.y = 2.5 + Math.cos(t * 0.3) * 0.15;

        ring2.rotation.x += 0.005;
        ring2.position.y = -1.8 + Math.sin(t * 0.35) * 0.1;

        particles.rotation.y += 0.0002;
        particles.rotation.x += 0.0001;
        lines.rotation.y += 0.00015;

        camera.position.x += (mx * 0.35 - camera.position.x) * 0.012;
        camera.position.y += (my * 0.2 - camera.position.y) * 0.012;
        camera.lookAt(scene.position);

        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
});
</script>
@endpush
