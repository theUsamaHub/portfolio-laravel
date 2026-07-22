<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\NavigationMenu;
use App\Models\HeroSection;
use App\Models\HeroCta;
use App\Models\RotatingProfession;
use App\Models\SocialLink;
use App\Models\AboutSection;
use App\Models\SkillCategory;
use App\Models\Skill;
use App\Models\Service;
use App\Models\ProjectCategory;
use App\Models\Project;
use App\Models\ProjectTechnology;
use App\Models\Tag;
use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Statistic;
use App\Models\Client;
use App\Models\SeoSetting;
use App\Models\ContactSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ───────────────────────────────────────
        User::create([
            'name' => 'Usama',
            'email' => 'admin@portfolio.dev',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // ─── Site Settings ────────────────────────────────────
        $settings = [
            'site_name'        => ['value' => 'Usama', 'group' => 'general'],
            'site_tagline'     => ['value' => 'Full Stack Developer & Software Architect', 'group' => 'general'],
            'site_description' => ['value' => 'I build scalable, secure, and beautifully crafted web applications that solve real problems.', 'group' => 'general'],
            'site_email'       => ['value' => 'usama@developer.dev', 'group' => 'contact'],
            'site_phone'       => ['value' => '+92 300 1234567', 'group' => 'contact'],
            'site_address'     => ['value' => 'Lahore, Pakistan', 'group' => 'contact'],
            'hero_title'       => ['value' => 'Building Digital Products That Scale', 'group' => 'hero'],
            'hero_subtitle'    => ['value' => 'Hello, I\'m', 'group' => 'hero'],
            'primary_color'    => ['value' => '#0A0A0A', 'group' => 'appearance'],
            'secondary_color'  => ['value' => '#EF4444', 'group' => 'appearance'],
            'footer_copyright' => ['value' => '© ' . date('Y') . ' Usama. All Rights Reserved.', 'group' => 'footer'],
            'auth_login_path'  => ['value' => 'a9x7k2m8', 'group' => 'auth'],
            'auth_register_path' => ['value' => '7f3a9b2c', 'group' => 'auth'],
            'auth_forgot_password_path' => ['value' => 'x4k8m2n9', 'group' => 'auth'],
            'auth_reset_password_path' => ['value' => 'r7p3w5q1', 'group' => 'auth'],
        ];

        foreach ($settings as $key => $data) {
            SiteSetting::create(array_merge(['key' => $key], $data));
        }

        // ─── Navigation ───────────────────────────────────────
        $navItems = [
            ['label' => 'Home',     'url' => '/',         'sort_order' => 1],
            ['label' => 'About',    'url' => '/about',    'sort_order' => 2],
            ['label' => 'Skills',   'url' => '/#skills',   'sort_order' => 3],
            ['label' => 'Work',     'url' => '/work',     'sort_order' => 4],
            ['label' => 'Services', 'url' => '/services', 'sort_order' => 5],
            ['label' => 'Blog',     'url' => '/blog',     'sort_order' => 6],
            ['label' => 'Contact',  'url' => '/#contact',  'sort_order' => 7],
        ];

        foreach ($navItems as $item) {
            NavigationMenu::create($item);
        }

        // ─── Hero Section ─────────────────────────────────────
        $hero = HeroSection::create([
            'title'       => 'Usama',
            'subtitle'    => 'Hello, I\'m',
            'description' => 'A full-stack developer and software architect crafting high-performance web applications, APIs, and cloud-native solutions. I turn complex problems into elegant, scalable products.',
            'is_active'   => true,
        ]);

        HeroCta::create(['hero_section_id' => $hero->id, 'label' => 'View My Work',  'url' => '#projects', 'style' => 'primary', 'sort_order' => 1]);
        HeroCta::create(['hero_section_id' => $hero->id, 'label' => 'Get In Touch', 'url' => '#contact',  'style' => 'outline', 'sort_order' => 2]);

        foreach (['Full Stack Developer', 'Software Architect', 'Open Source Enthusiast', 'Problem Solver'] as $i => $prof) {
            RotatingProfession::create(['hero_section_id' => $hero->id, 'profession' => $prof, 'sort_order' => $i]);
        }

        // ─── Social Links ─────────────────────────────────────
        $socials = [
            ['platform' => 'GitHub',   'url' => 'https://github.com/usama',   'icon' => 'github',   'sort_order' => 1],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com/in/usama', 'icon' => 'linkedin', 'sort_order' => 2],
            ['platform' => 'Twitter',  'url' => 'https://twitter.com/usama',  'icon' => 'twitter',  'sort_order' => 3],
        ];
        foreach ($socials as $s) SocialLink::create($s);

        // ─── About Section ────────────────────────────────────
        AboutSection::create([
            'title'            => 'About Me',
            'subtitle'         => 'Who I Am',
            'description'      => 'I\'m a passionate full-stack developer with 6+ years of experience building production-grade web applications. I specialize in Laravel, React, PostgreSQL, and cloud infrastructure on AWS. My approach combines clean architecture with pragmatic engineering — I build systems that are maintainable today and scalable tomorrow. When I\'m not coding, you\'ll find me contributing to open-source projects, writing technical articles, or exploring new technologies.',
            'highlights'       => ['Laravel & PHP', 'React & TypeScript', 'PostgreSQL & Redis', 'AWS & Docker', 'REST & GraphQL APIs', 'System Design'],
            'experience_years' => 6,
            'location'         => 'Lahore, Pakistan',
            'languages'        => ['English', 'Urdu', 'Arabic'],
            'is_active'        => true,
        ]);

        // ─── Skill Categories & Skills ────────────────────────
        $categories = [
            'Backend' => [
                'PHP'          => 95,
                'Laravel'      => 92,
                'Node.js'      => 78,
                'Python'       => 65,
                'PostgreSQL'   => 88,
                'Redis'        => 80,
            ],
            'Frontend' => [
                'JavaScript'   => 90,
                'React'        => 85,
                'TypeScript'   => 82,
                'Vue.js'       => 75,
                'HTML/CSS'     => 92,
                'Tailwind CSS' => 88,
            ],
            'DevOps & Cloud' => [
                'Docker'       => 85,
                'AWS'          => 80,
                'Git'          => 92,
                'CI/CD'        => 78,
                'Linux'        => 88,
                'Nginx'        => 75,
            ],
        ];

        foreach ($categories as $catName => $skills) {
            $cat = SkillCategory::create([
                'name'       => $catName,
                'slug'       => Str::slug($catName),
                'sort_order' => array_search($catName, array_keys($categories)),
            ]);
            foreach ($skills as $skillName => $percentage) {
                Skill::create([
                    'skill_category_id' => $cat->id,
                    'name'              => $skillName,
                    'slug'              => Str::slug($skillName),
                    'percentage'        => $percentage,
                    'sort_order'        => array_search($skillName, array_keys($skills)),
                ]);
            }
        }

        // ─── Services ─────────────────────────────────────────
        $services = [
            [
                'name'        => 'Web Application Development',
                'slug'        => 'web-application-development',
                'description' => 'End-to-end web application development using Laravel, React, and modern PHP. From MVPs to enterprise platforms — clean code, solid architecture, and production-ready deployments.',
                'icon'        => '💻',
                'features'    => ['Laravel & PHP', 'React & Vue.js', 'REST & GraphQL APIs', 'Real-time Features'],
            ],
            [
                'name'        => 'Cloud Infrastructure & DevOps',
                'slug'        => 'cloud-infrastructure-devops',
                'description' => 'Scalable cloud architecture on AWS with Docker containerization, CI/CD pipelines, and infrastructure as code. Deploy with confidence and scale with ease.',
                'icon'        => '☁️',
                'features'    => ['AWS / GCP', 'Docker & Kubernetes', 'CI/CD Pipelines', 'Monitoring & Alerts'],
            ],
            [
                'name'        => 'API Design & Integration',
                'slug'        => 'api-design-integration',
                'description' => 'High-performance RESTful and GraphQL APIs built for reliability. Third-party integrations, payment gateways, and webhook systems that just work.',
                'icon'        => '⚡',
                'features'    => ['REST API Design', 'GraphQL', 'Payment Integration', 'Webhook Systems'],
            ],
        ];

        foreach ($services as $i => $s) {
            Service::create(array_merge($s, ['sort_order' => $i, 'is_active' => true]));
        }

        // ─── Project Categories & Tags ────────────────────────
        $webCategory     = ProjectCategory::create(['name' => 'Web Application', 'slug' => 'web-application', 'sort_order' => 1]);
        $saasCategory    = ProjectCategory::create(['name' => 'SaaS Platform',   'slug' => 'saas-platform',   'sort_order' => 2]);
        $apiCategory     = ProjectCategory::create(['name' => 'API / Backend',    'slug' => 'api-backend',     'sort_order' => 3]);

        $tags = ['Laravel', 'React', 'PostgreSQL', 'Docker', 'AWS', 'REST API', 'GraphQL', 'TypeScript', 'Node.js', 'Tailwind CSS', 'Redis', 'Git', 'CI/CD', 'Full Stack', 'Backend', 'DevOps', 'WebSocket', 'Stripe', 'Vite', 'Alpine.js'];
        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName)]);
        }

        // ─── Projects ─────────────────────────────────────────
        $projects = [
            [
                'name'               => 'CloudDeploy Dashboard',
                'slug'               => 'clouddeploy-dashboard',
                'description'        => 'A full-featured cloud deployment platform that lets developers deploy, manage, and monitor their applications from a single dashboard. Built with Laravel backend, React frontend, and AWS integration. Features real-time deployment logs, auto-scaling configuration, and cost analytics.',
                'short_description'  => 'Cloud deployment platform with real-time monitoring and auto-scaling.',
                'status'             => 'published',
                'project_category_id' => $saasCategory->id,
                'is_featured'        => true,
                'client_name'        => 'Internal Project',
                'project_url'        => 'https://clouddeploy.dev',
                'sort_order'         => 1,
            ],
            [
                'name'               => 'InvoiceFlow',
                'slug'               => 'invoiceflow',
                'description'        => 'A modern invoicing and billing SaaS for freelancers and small businesses. Features include recurring invoices, payment tracking via Stripe, client portals, tax calculations, and PDF generation. Built with Laravel, Livewire, and PostgreSQL.',
                'short_description'  => 'Invoicing SaaS with Stripe payments and client portals.',
                'status'             => 'published',
                'project_category_id' => $saasCategory->id,
                'is_featured'        => true,
                'client_name'        => 'Freelance Project',
                'project_url'        => 'https://invoiceflow.io',
                'sort_order'         => 2,
            ],
            [
                'name'               => 'E-Commerce Platform',
                'slug'               => 'e-commerce-platform',
                'description'        => 'A full-featured e-commerce platform with real-time inventory management, multi-vendor support, payment processing via Stripe and PayPal, and a comprehensive admin dashboard. Built for high traffic with Redis caching and queue-based order processing.',
                'short_description'  => 'Multi-vendor e-commerce with real-time inventory and payments.',
                'status'             => 'published',
                'project_category_id' => $webCategory->id,
                'is_featured'        => true,
                'client_name'        => 'TechVentures',
                'sort_order'         => 3,
            ],
            [
                'name'               => 'REST API Gateway',
                'slug'               => 'rest-api-gateway',
                'description'        => 'A scalable API gateway service handling authentication, rate limiting, request routing, and analytics for multiple microservices. Processes 15k+ requests per minute with sub-50ms response times. Built with Laravel and Redis.',
                'short_description'  => 'High-performance API gateway handling 15k+ req/min.',
                'status'             => 'published',
                'project_category_id' => $apiCategory->id,
                'is_featured'        => true,
                'sort_order'         => 4,
            ],
        ];

        foreach ($projects as $pData) {
            $project = Project::create($pData);
            $project->tags()->attach(collect($tagModels)->slice(0, 4)->pluck('id')->toArray());
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'Laravel',     'sort_order' => 0]);
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'React',       'sort_order' => 1]);
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'PostgreSQL',  'sort_order' => 2]);
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'Redis',       'sort_order' => 3]);
        }

        // ─── Blog Categories & Posts ──────────────────────────
        $techCat     = BlogCategory::create(['name' => 'Technology', 'slug' => 'technology', 'sort_order' => 1]);
        $tutorialCat = BlogCategory::create(['name' => 'Tutorials',  'slug' => 'tutorials',  'sort_order' => 2]);
        $opinionCat  = BlogCategory::create(['name' => 'Opinions',   'slug' => 'opinions',   'sort_order' => 3]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Why Laravel Remains the Best PHP Framework in 2026',
            'slug'             => 'why-laravel-remains-best-php-framework-2026',
            'excerpt'          => 'After years of building with various frameworks, here\'s why I keep coming back to Laravel for production applications.',
            'content'          => '<p>Laravel has evolved significantly over the past few years. With Laravel 13, the framework continues to push the boundaries of what\'s possible with PHP.</p><h2>The Ecosystem</h2><p>From Forge to Vapor, from Pennant to Folio — the Laravel ecosystem provides tools for every stage of development. This isn\'t just a framework; it\'s a complete platform for building and deploying web applications.</p><h2>Developer Experience</h2><p>The developer experience remains unmatched. Artisan commands, Eloquent ORM, Blade templating — every piece is designed to make you productive without sacrificing power.</p><h2>Performance</h2><p>With improvements to the router, cache, and queue systems, Laravel 13 delivers performance that rivals compiled frameworks while maintaining the flexibility PHP developers expect.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(12),
            'reading_time'     => 6,
            'is_featured'      => true,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Building a Production-Ready REST API with Laravel',
            'slug'             => 'building-production-ready-rest-api-laravel',
            'excerpt'          => 'A step-by-step guide to building APIs that handle real traffic — authentication, rate limiting, versioning, and monitoring.',
            'content'          => '<p>Building an API that works on your laptop is easy. Building one that handles production traffic requires careful planning.</p><h2>Authentication</h2><p>Start with Laravel Sanctum for token-based authentication. It provides a clean, simple API for issuing tokens that can authenticate SPAs, mobile apps, and third-party integrations.</p><h2>Rate Limiting</h2><p>Use Laravel\'s built-in rate limiting to protect your API from abuse. Define per-route limits and implement sliding window algorithms for fair usage.</p><h2>Versioning</h2><p>API versioning is non-negotiable. Use URL-based versioning (v1, v2) for simplicity, and maintain backward compatibility through transformers.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(10),
            'reading_time'     => 10,
        ]);

        Post::create([
            'blog_category_id' => $opinionCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'The Case for Server-Side Rendering in 2026',
            'slug'             => 'case-for-server-side-rendering-2026',
            'excerpt'          => 'Why I\'m moving away from SPAs for most projects and embracing the simplicity of server-rendered applications.',
            'content'          => '<p>For years, the default answer to "how should we build this?" was "React SPA." But after building dozens of production applications, I\'ve changed my mind.</p><h2>The Complexity Tax</h2><p>SPAs introduce a layer of complexity that most projects don\'t need. State management, build pipelines, hydration errors, bundle splitting — all of this adds up.</p><h2>Server-Side Rendering</h2><p>With tools like Inertia.js and Livewire, you get the interactivity of a SPA with the simplicity of server rendering. No API layer, no state management library, no hydration mismatches.</p><h2>When SPAs Make Sense</h2><p>SPAs still make sense for complex dashboards, real-time collaboration tools, and applications where the UI is the primary product. But for content-driven sites, e-commerce, and most CRUD applications, server rendering is the better choice.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(8),
            'reading_time'     => 7,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Docker for Laravel Developers: A Practical Guide',
            'slug'             => 'docker-for-laravel-developers-practical-guide',
            'excerpt'          => 'Stop the "works on my machine" problem. Learn how to containerize your Laravel app with Docker from scratch.',
            'content'          => '<p>Docker has become essential for modern web development. Here\'s how to set up a complete Laravel development environment with Docker.</p><h2>Why Docker?</h2><p>Every developer has a different OS, PHP version, and extension setup. Docker gives you a consistent environment that matches production exactly.</p><h2>The Dockerfile</h2><p>Start with a PHP 8.3 FPM image, install required extensions (pdo_pgsql, mbstring, redis, imagick), and configure PHP-FPM for optimal performance.</p><h2>Docker Compose</h2><p>Use docker-compose.yml to orchestrate your services: PHP-FPM, Nginx, PostgreSQL, and Redis. Define volumes for live code reloading and networks for inter-service communication.</p><h2>Development Workflow</h2><p>Mount your source code as a volume so changes reflect instantly. Use Artisan commands inside the container: <code>docker compose exec php php artisan migrate</code>.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(6),
            'reading_time'     => 12,
        ]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'PostgreSQL Performance Tuning for Web Applications',
            'slug'             => 'postgresql-performance-tuning-web-applications',
            'excerpt'          => 'Optimize your PostgreSQL queries and configuration for maximum performance in production Laravel applications.',
            'content'          => '<p>PostgreSQL is powerful out of the box, but proper tuning can make the difference between a 50ms response and a 500ms response.</p><h2>Indexing Strategy</h2><p>The most impactful optimization is proper indexing. Analyze your query patterns with <code>EXPLAIN ANALYZE</code> and create composite indexes for frequently joined columns.</p><h2>Connection Pooling</h2><p>Use PgBouncer or Laravel\'s built-in connection pooling to manage database connections efficiently. A pool of 20 connections can serve hundreds of concurrent requests.</p><h2>Query Optimization</h2><p>Avoid N+1 queries with eager loading. Use chunking for large datasets. Leverage PostgreSQL-specific features like CTEs, window functions, and materialized views.</p><h2>Configuration</h2><p>Tune <code>shared_buffers</code>, <code>work_mem</code>, and <code>effective_cache_size</code> based on your server\'s available RAM. These three settings alone can double your throughput.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(5),
            'reading_time'     => 9,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Real-Time Features with Laravel WebSockets',
            'slug'             => 'real-time-features-laravel-websockets',
            'excerpt'          => 'Add live notifications, real-time updates, and broadcasting to your Laravel app without external services.',
            'content'          => '<p>Real-time features are no longer optional. Users expect live updates, notifications, and collaborative editing. Here\'s how to add them with Laravel.</p><h2>Broadcasting Basics</h2><p>Laravel\'s broadcasting system works with WebSockets, Pusher, and Ably. For self-hosted solutions, use Laravel WebSockets or Soketi.</p><h2>Events and Channels</h2><p>Define broadcast events that implement <code>ShouldBroadcast</code>. Choose between public channels (anyone can listen), private channels (authenticated users), and presence channels (track who\'s online).</p><h2>Frontend Integration</h2><p>Use Laravel Echo on the frontend to subscribe to channels and listen for events. With React or Vue, wrap the listener in a composable or hook for clean integration.</p><h2>Use Cases</h2><p>Live notifications, real-time dashboards, collaborative editing, live chat, activity feeds, and status updates.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(4),
            'reading_time'     => 11,
        ]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'AWS Lambda vs EC2: Choosing the Right Compute for Your App',
            'slug'             => 'aws-lambda-vs-ec2-choosing-right-compute',
            'excerpt'          => 'Serverless isn\'t always the answer. Here\'s when to use Lambda, when to use EC2, and when to use both.',
            'content'          => '<p>The serverless vs. containers debate is nuanced. The right choice depends on your workload, not industry trends.</p><h2>When Lambda Wins</h2><p>Event-driven workloads, scheduled tasks, API endpoints with variable traffic, image processing, and webhook handlers. Lambda scales to zero and you only pay for execution time.</p><h2>When EC2 Wins</h2><p>Long-running processes, WebSocket connections, databases, Redis, and workloads with consistent traffic patterns. EC2 gives you full control over the environment.</p><h2>The Hybrid Approach</h2><p>Use Lambda for API endpoints and background jobs, EC2 for databases and persistent services. This gives you the best of both worlds: scale-to-zero for bursty traffic, predictable costs for steady workloads.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(3),
            'reading_time'     => 8,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Building a Contact Form with reCAPTCHA and Email Notifications',
            'slug'             => 'building-contact-form-recaptcha-email-notifications',
            'excerpt'          => 'A complete guide to creating a secure contact form with spam protection and instant email alerts.',
            'content'          => '<p>Every portfolio needs a contact form. Here\'s how to build one that actually works in production.</p><h2>Spam Protection</h2><p>Add Google reCAPTCHA v3 to silently score submissions. Blocks bots without annoying CAPTCHAs. Configure the threshold to reject obvious spam while letting real users through.</p><h2>Form Validation</h2><p>Use Laravel\'s validation rules for server-side validation. Never trust client-side validation alone. Validate email format, required fields, and string lengths.</p><h2>Email Notifications</h2><p>Send a notification to yourself when someone submits the form. Use Laravel\'s Mail system with a Markdown mailable for clean, maintainable email templates.</p><h2>Storage and Management</h2><p>Store submissions in the database with status tracking (unread, read, replied, archived). Build an admin panel to manage and respond to messages.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDays(2),
            'reading_time'     => 8,
        ]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Git Workflow Strategies for Solo Developers',
            'slug'             => 'git-workflow-strategies-solo-developers',
            'excerpt'          => 'You don\'t need a team to use Git properly. Here are workflows that keep solo projects clean and deployable.',
            'content'          => '<p>Git isn\'t just for teams. Solo developers benefit enormously from a disciplined workflow.</p><h2>Feature Branches</h2><p>Even alone, create a branch for every feature or fix. It keeps your main branch clean and makes it easy to revert changes if something breaks.</p><h2>Conventional Commits</h2><p>Use <code>feat:</code>, <code>fix:</code>, <code>chore:</code> prefixes. This generates changelogs automatically and makes git log readable months later.</p><h2>The Stack</h2><p>Use <code>git stash</code> to save work-in-progress. Use <code>git rebase -i</code> to squash commits before merging. Keep a linear history on main.</p><h2>Deployment</h2><p>Use GitHub Actions to auto-deploy on push to main. Your workflow: push to feature branch, create PR, merge, auto-deploy. No manual steps.</p>',
            'status'           => 'published',
            'published_at'     => now()->subDay(),
            'reading_time'     => 6,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Deploying Laravel to AWS with CI/CD Pipeline',
            'slug'             => 'deploying-laravel-aws-cicd-pipeline',
            'excerpt'          => 'Automate your deployment process with GitHub Actions, AWS ECS, and zero-downtime releases.',
            'content'          => '<p>Manual deployments are error-prone and slow. Here\'s how to set up a fully automated CI/CD pipeline for Laravel on AWS.</p><h2>Architecture Overview</h2><p>Use GitHub Actions for CI, AWS ECR for container images, and ECS Fargate for running containers. No servers to manage.</p><h2>The Pipeline</h2><p>On every push to main: run tests, build Docker image, push to ECR, update ECS service. The entire process takes under 5 minutes.</p><h2>Zero-Downtime Deployments</h2><p>ECS rolling updates ensure old tasks keep running until new tasks are healthy. No downtime, no manual intervention.</p><h2>Environment Variables</h2><p>Store secrets in AWS SSM Parameter Store or Secrets Manager. Inject them into containers at runtime. Never commit .env files to Git.</p>',
            'status'           => 'published',
            'published_at'     => now()->subHours(12),
            'reading_time'     => 14,
        ]);

        Post::create([
            'blog_category_id' => $opinionCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Why I Stopped Using ORM Eager Loading (Sometimes)',
            'slug'             => 'stopped-using-orm-eager-loading-sometimes',
            'excerpt'          => 'Eager loading is great, but sometimes a raw query is the right choice. Here\'s when I break the rules.',
            'content'          => '<p>Eloquent is beautiful. But sometimes beauty is slow.</p><h2>The Problem</h2><p>Complex reports with 10+ joins, aggregations across multiple tables, and subqueries in WHERE clauses — Eloquent struggles here. The query builder helps, but raw SQL is sometimes clearer.</p><h2>When I Go Raw</h2><p>Dashboard analytics, export features, complex search with full-text indexing, and geospatial queries. These are performance-critical paths where every millisecond counts.</p><h2>The Hybrid Approach</h2><p>Use Eloquent for CRUD and simple queries. Use the query builder for moderate complexity. Drop to raw SQL for performance-critical reports. Bind results to Eloquent models with <code>hydrate()</code>.</p><h2>Trade-offs</h2><p>You lose some Eloquent convenience but gain 10x performance on complex queries. The key is knowing when the trade-off is worth it.</p>',
            'status'           => 'published',
            'published_at'     => now()->subHours(6),
            'reading_time'     => 7,
        ]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id'        => User::first()->id,
            'name'             => 'Redis Beyond Caching: Queues, Sessions, and Real-Time',
            'slug'             => 'redis-beyond-caching-queues-sessions-real-time',
            'excerpt'          => 'Redis is more than a cache. Discover how to use it for queues, sessions, rate limiting, and pub/sub messaging.',
            'content'          => '<p>Most developers use Redis as a simple cache. But Redis is a Swiss Army knife for web applications.</p><h2>Queue Backend</h2><p>Redis queues are faster than database queues. Use them for background jobs, email sending, image processing, and any task that can wait a few seconds.</p><h2>Session Storage</h2><p>Redis sessions are faster than database sessions and support automatic expiration. Perfect for high-traffic applications.</p><h2>Rate Limiting</h2><p>Redis\'s INCR and EXPIRE commands make rate limiting trivial. Laravel\'s rate limiter uses Redis under the hood.</p><h2>Pub/Sub</h2><p>Redis pub/sub enables real-time features without WebSockets. Broadcast events to multiple subscribers instantly. Great for notifications and live feeds.</p>',
            'status'           => 'published',
            'published_at'     => now()->subHours(2),
            'reading_time'     => 8,
        ]);

        // ─── Testimonials ─────────────────────────────────────
        Testimonial::create([
            'client_name'    => 'Ahmad Raza',
            'client_position' => 'CTO',
            'client_company' => 'TechVentures',
            'content'        => 'Usama delivered an exceptional e-commerce platform that handled our Black Friday traffic without a hiccup. His understanding of scalable architecture and attention to performance细节 is outstanding. Truly a 10x developer.',
            'rating'         => 5,
            'is_featured'    => true,
            'sort_order'     => 1,
        ]);

        Testimonial::create([
            'client_name'    => 'Sarah Mitchell',
            'client_position' => 'Founder',
            'client_company' => 'StartupLab',
            'content'        => 'Working with Usama was a game-changer for our startup. He didn\'t just write code — he understood our business goals and built a platform that grew with us. From MVP to 10k users in 3 months.',
            'rating'         => 5,
            'is_featured'    => true,
            'sort_order'     => 2,
        ]);

        Testimonial::create([
            'client_name'    => 'Bilal Khan',
            'client_position' => 'Engineering Lead',
            'client_company' => 'CloudFirst',
            'content'        => 'Usama architected our microservices infrastructure on AWS. His knowledge of Docker, CI/CD, and cloud-native patterns is impressive. The system he built handles 50k+ daily active users with 99.9% uptime.',
            'rating'         => 5,
            'is_featured'    => true,
            'sort_order'     => 3,
        ]);

        // ─── Experience ───────────────────────────────────────
        Experience::create([
            'company'         => 'CloudFirst Technologies',
            'position'        => 'Senior Full Stack Developer',
            'description'     => 'Leading development of cloud-native SaaS applications. Architected microservices infrastructure serving 50k+ daily users. Mentoring junior developers and establishing coding standards across the team.',
            'location'        => 'Lahore, Pakistan',
            'start_date'      => '2023-01-01',
            'is_current'      => true,
            'is_active'       => true,
            'sort_order'      => 1,
        ]);

        Experience::create([
            'company'         => 'TechVentures',
            'position'        => 'Full Stack Developer',
            'description'     => 'Built and maintained the core e-commerce platform. Developed payment integrations with Stripe and PayPal, implemented real-time inventory management, and optimized database queries reducing page load times by 40%.',
            'location'        => 'Remote',
            'start_date'      => '2021-03-01',
            'end_date'        => '2022-12-31',
            'is_active'       => true,
            'sort_order'      => 2,
        ]);

        Experience::create([
            'company'         => 'StartupLab',
            'position'        => 'Junior Developer',
            'description'     => 'Started my professional journey building Laravel applications. Developed REST APIs, created Blade interfaces, and learned the fundamentals of production-grade software development.',
            'location'        => 'Lahore, Pakistan',
            'start_date'      => '2019-06-01',
            'end_date'        => '2021-02-28',
            'is_active'       => true,
            'sort_order'      => 3,
        ]);

        // ─── Education ────────────────────────────────────────
        Education::create([
            'institution'   => 'University of Engineering and Technology, Lahore',
            'degree'        => 'Bachelor of Science',
            'field_of_study' => 'Computer Science',
            'description'   => 'Graduated with honors. Coursework included Data Structures, Algorithms, Database Systems, Software Engineering, and Computer Networks.',
            'start_date'    => '2015-09-01',
            'end_date'      => '2019-06-30',
            'grade'         => '3.8 / 4.0',
            'is_active'     => true,
            'sort_order'    => 1,
        ]);

        // ─── Statistics ───────────────────────────────────────
        Statistic::create(['label' => 'Years Experience',   'value' => 6,   'suffix' => '+', 'is_active' => true, 'sort_order' => 1]);
        Statistic::create(['label' => 'Projects Delivered', 'value' => 45,  'suffix' => '+', 'is_active' => true, 'sort_order' => 2]);
        Statistic::create(['label' => 'Happy Clients',      'value' => 30,  'suffix' => '+', 'is_active' => true, 'sort_order' => 3]);
        Statistic::create(['label' => 'Technologies',       'value' => 25,  'suffix' => '+', 'is_active' => true, 'sort_order' => 4]);

        // ─── Clients ──────────────────────────────────────────
        Client::create(['name' => 'TechVentures',    'sort_order' => 1]);
        Client::create(['name' => 'CloudFirst',      'sort_order' => 2]);
        Client::create(['name' => 'StartupLab',      'sort_order' => 3]);
        Client::create(['name' => 'DataPulse',       'sort_order' => 4]);
        Client::create(['name' => 'FinServe',        'sort_order' => 5]);

        // ─── Contact Settings ─────────────────────────────────
        ContactSetting::create([
            'email'     => 'usama@developer.dev',
            'phone'     => '+92 300 1234567',
            'whatsapp'  => '+92 300 1234567',
            'address'   => 'Gulberg III, Lahore',
            'city'      => 'Lahore',
            'state'     => 'Punjab',
            'country'   => 'Pakistan',
            'is_active' => true,
        ]);

        // ─── SEO Settings ─────────────────────────────────────
        SeoSetting::create([
            'page'             => 'home',
            'meta_title'       => 'Usama — Full Stack Developer & Software Architect',
            'meta_description' => 'Full-stack developer specializing in Laravel, React, PostgreSQL, and AWS. Building scalable web applications and cloud-native solutions.',
            'keywords'         => 'full stack developer, laravel, react, postgresql, aws, web development, php, javascript',
        ]);

        SeoSetting::create([
            'page'             => 'projects',
            'meta_title'       => 'Projects — Usama',
            'meta_description' => 'Featured projects and case studies showcasing web applications, SaaS platforms, and API systems built by Usama.',
        ]);

        SeoSetting::create([
            'page'             => 'blog',
            'meta_title'       => 'Blog — Usama',
            'meta_description' => 'Technical articles, tutorials, and opinions on web development, Laravel, and software architecture.',
        ]);
    }
}
