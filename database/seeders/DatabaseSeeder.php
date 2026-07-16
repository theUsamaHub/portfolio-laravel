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
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@portfolio.dev',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Site Settings
        $settings = [
            'site_name' => ['value' => 'John Developer', 'group' => 'general'],
            'site_tagline' => ['value' => 'Full Stack Developer & Software Engineer', 'group' => 'general'],
            'site_description' => ['value' => 'I build scalable web applications and modern digital experiences.', 'group' => 'general'],
            'site_email' => ['value' => 'hello@johndeveloper.com', 'group' => 'contact'],
            'site_phone' => ['value' => '+1 (555) 123-4567', 'group' => 'contact'],
            'site_address' => ['value' => 'San Francisco, CA', 'group' => 'contact'],
            'hero_title' => ['value' => 'Building Digital Experiences That Matter', 'group' => 'hero'],
            'hero_subtitle' => ['value' => 'Hello, I\'m', 'group' => 'hero'],
            'primary_color' => ['value' => '#2563EB', 'group' => 'appearance'],
            'secondary_color' => ['value' => '#7C3AED', 'group' => 'appearance'],
            'footer_copyright' => ['value' => '© 2025 John Developer. All Rights Reserved.', 'group' => 'footer'],
        ];

        foreach ($settings as $key => $data) {
            SiteSetting::create(array_merge(['key' => $key], $data));
        }

        // Navigation
        $navItems = [
            ['label' => 'Home', 'url' => '/#hero', 'sort_order' => 1],
            ['label' => 'About', 'url' => '/#about', 'sort_order' => 2],
            ['label' => 'Skills', 'url' => '/#skills', 'sort_order' => 3],
            ['label' => 'Projects', 'url' => '/projects', 'sort_order' => 4],
            ['label' => 'Blog', 'url' => '/blog', 'sort_order' => 5],
            ['label' => 'Contact', 'url' => '/#contact', 'sort_order' => 6],
        ];

        foreach ($navItems as $item) {
            NavigationMenu::create($item);
        }

        // Hero Section
        $hero = HeroSection::create([
            'title' => 'Building Digital Experiences That Matter',
            'subtitle' => 'Hello, I\'m John',
            'description' => 'I\'m a full-stack developer passionate about creating scalable, secure, and beautifully designed web applications.',
            'is_active' => true,
        ]);

        HeroCta::create(['hero_section_id' => $hero->id, 'label' => 'View Projects', 'url' => '/projects', 'style' => 'primary', 'sort_order' => 1]);
        HeroCta::create(['hero_section_id' => $hero->id, 'label' => 'Contact Me', 'url' => '/#contact', 'style' => 'outline', 'sort_order' => 2]);

        foreach (['Full Stack Developer', 'Software Engineer', 'UI/UX Enthusiast', 'Problem Solver'] as $i => $prof) {
            RotatingProfession::create(['hero_section_id' => $hero->id, 'profession' => $prof, 'sort_order' => $i]);
        }

        // Social Links
        $socials = [
            ['platform' => 'GitHub', 'url' => 'https://github.com', 'icon' => 'github', 'sort_order' => 1],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com', 'icon' => 'linkedin', 'sort_order' => 2],
            ['platform' => 'Twitter', 'url' => 'https://twitter.com', 'icon' => 'twitter', 'sort_order' => 3],
        ];
        foreach ($socials as $s) SocialLink::create($s);

        // About Section
        AboutSection::create([
            'title' => 'About Me',
            'subtitle' => 'Who I Am',
            'description' => 'I\'m a passionate full-stack developer with over 5 years of experience building web applications. I specialize in Laravel, Vue.js, and cloud architecture. I love solving complex problems and creating elegant solutions.',
            'highlights' => ['Laravel & PHP Expert', 'Vue.js & React', 'Cloud Architecture', 'Database Design', 'API Development', 'DevOps'],
            'experience_years' => 5,
            'location' => 'San Francisco, CA',
            'languages' => ['English', 'Spanish', 'JavaScript'],
            'is_active' => true,
        ]);

        // Skill Categories & Skills
        $categories = [
            'Backend' => ['PHP' => 95, 'Laravel' => 90, 'Node.js' => 80, 'Python' => 70, 'PostgreSQL' => 85, 'Redis' => 75],
            'Frontend' => ['JavaScript' => 90, 'Vue.js' => 85, 'React' => 75, 'TypeScript' => 80, 'HTML/CSS' => 95, 'Tailwind CSS' => 90],
            'DevOps' => ['Docker' => 80, 'AWS' => 75, 'Git' => 90, 'CI/CD' => 70, 'Linux' => 85, 'Nginx' => 75],
        ];

        foreach ($categories as $catName => $skills) {
            $cat = SkillCategory::create(['name' => $catName, 'slug' => Str::slug($catName), 'sort_order' => array_search($catName, array_keys($categories))]);
            foreach ($skills as $skillName => $percentage) {
                Skill::create(['skill_category_id' => $cat->id, 'name' => $skillName, 'slug' => Str::slug($skillName), 'percentage' => $percentage, 'sort_order' => array_search($skillName, array_keys($skills))]);
            }
        }

        // Services
        $services = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Custom web applications built with modern technologies. From simple websites to complex enterprise solutions.', 'icon' => '💻', 'features' => ['Custom Development', 'API Integration', 'Performance Optimization', 'SEO Friendly']],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development', 'description' => 'Cross-platform mobile applications that deliver native-like experiences on both iOS and Android.', 'icon' => '📱', 'features' => ['React Native', 'Flutter', 'iOS & Android', 'App Store Deployment']],
            ['name' => 'Cloud Solutions', 'slug' => 'cloud-solutions', 'description' => 'Scalable cloud infrastructure setup and management. Deploy with confidence on AWS, GCP, or Azure.', 'icon' => '☁️', 'features' => ['AWS/GCP/Azure', 'Auto-scaling', 'CI/CD Pipelines', 'Monitoring & Alerts']],
        ];

        foreach ($services as $i => $s) {
            Service::create(array_merge($s, ['sort_order' => $i, 'is_active' => true]));
        }

        // Project Categories & Tags
        $webCategory = ProjectCategory::create(['name' => 'Web Application', 'slug' => 'web-application', 'sort_order' => 1]);
        $mobileCategory = ProjectCategory::create(['name' => 'Mobile App', 'slug' => 'mobile-app', 'sort_order' => 2]);
        $apiCategory = ProjectCategory::create(['name' => 'API / Backend', 'slug' => 'api-backend', 'sort_order' => 3]);

        $tags = ['Laravel', 'Vue.js', 'React', 'PostgreSQL', 'Docker', 'AWS', 'REST API', 'GraphQL', 'TypeScript', 'Node.js', 'Tailwind CSS', 'Alpine.js', 'Redis', 'Git', 'CI/CD', 'API Design', 'Full Stack', 'Frontend', 'Backend', 'DevOps'];
        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName)]);
        }

        // Projects
        $projects = [
            ['name' => 'E-Commerce Platform', 'slug' => 'e-commerce-platform', 'description' => 'A full-featured e-commerce platform with real-time inventory management, payment processing, and admin dashboard.', 'short_description' => 'Full-featured e-commerce with real-time inventory.', 'status' => 'published', 'project_category_id' => $webCategory->id, 'is_featured' => true, 'client_name' => 'TechCorp', 'sort_order' => 1],
            ['name' => 'Task Management App', 'slug' => 'task-management-app', 'description' => 'A collaborative project management tool with real-time updates, team workspaces, and analytics dashboard.', 'short_description' => 'Collaborative project management with real-time updates.', 'status' => 'published', 'project_category_id' => $webCategory->id, 'is_featured' => true, 'sort_order' => 2],
            ['name' => 'REST API Service', 'slug' => 'rest-api-service', 'description' => 'A scalable REST API built with Laravel for a mobile banking application. Handles 10k+ requests per minute.', 'short_description' => 'High-performance REST API for mobile banking.', 'status' => 'published', 'project_category_id' => $apiCategory->id, 'is_featured' => true, 'sort_order' => 3],
        ];

        foreach ($projects as $pData) {
            $project = Project::create($pData);
            $project->tags()->attach(collect($tagModels)->slice(0, 3)->pluck('id')->toArray());
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'Laravel', 'sort_order' => 0]);
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'Vue.js', 'sort_order' => 1]);
            ProjectTechnology::create(['project_id' => $project->id, 'name' => 'PostgreSQL', 'sort_order' => 2]);
        }

        // Blog Categories & Posts
        $techCat = BlogCategory::create(['name' => 'Technology', 'slug' => 'technology', 'sort_order' => 1]);
        $tutorialCat = BlogCategory::create(['name' => 'Tutorials', 'slug' => 'tutorials', 'sort_order' => 2]);

        Post::create([
            'blog_category_id' => $techCat->id,
            'author_id' => User::first()->id,
            'name' => 'Getting Started with Laravel 13',
            'slug' => 'getting-started-with-laravel-13',
            'excerpt' => 'A comprehensive guide to building modern applications with Laravel 13.',
            'content' => '<p>Laravel 13 brings exciting new features and improvements. In this guide, we\'ll explore the key changes and how to leverage them in your projects.</p><h2>Installation</h2><p>Getting started is easier than ever with the streamlined installation process.</p><h2>Key Features</h2><p>Laravel 13 introduces improved performance, better testing support, and enhanced security features out of the box.</p>',
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'reading_time' => 5,
            'is_featured' => true,
        ]);

        Post::create([
            'blog_category_id' => $tutorialCat->id,
            'author_id' => User::first()->id,
            'name' => 'Building a Portfolio CMS with Laravel',
            'slug' => 'building-portfolio-cms-laravel',
            'excerpt' => 'Learn how to build a dynamic portfolio CMS from scratch.',
            'content' => '<p>In this tutorial, we\'ll build a complete portfolio CMS using Laravel, Blade, and modern web technologies.</p><p>This project covers database design, authentication, admin panels, and public-facing views.</p>',
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'reading_time' => 10,
        ]);

        // Testimonials
        Testimonial::create(['client_name' => 'Sarah Johnson', 'client_position' => 'CTO', 'client_company' => 'TechCorp', 'content' => 'John delivered an exceptional e-commerce platform that exceeded our expectations. His attention to detail and technical expertise are outstanding.', 'rating' => 5, 'is_featured' => true, 'sort_order' => 1]);
        Testimonial::create(['client_name' => 'Mike Chen', 'client_position' => 'Founder', 'client_company' => 'StartupXYZ', 'content' => 'Working with John was a great experience. He understood our vision and built a scalable solution that grew with our business.', 'rating' => 5, 'is_featured' => true, 'sort_order' => 2]);

        // Experience
        Experience::create(['company' => 'TechCorp', 'position' => 'Senior Full Stack Developer', 'description' => 'Led development of enterprise web applications using Laravel and Vue.js.', 'location' => 'San Francisco, CA', 'start_date' => '2022-01-01', 'is_current' => true, 'is_active' => true, 'sort_order' => 1]);
        Experience::create(['company' => 'StartupXYZ', 'position' => 'Full Stack Developer', 'description' => 'Built and maintained the core platform serving 50k+ users.', 'location' => 'Remote', 'start_date' => '2020-06-01', 'end_date' => '2021-12-31', 'is_active' => true, 'sort_order' => 2]);

        // Education
        Education::create(['institution' => 'University of California', 'degree' => 'Bachelor of Science', 'field_of_study' => 'Computer Science', 'start_date' => '2016-09-01', 'end_date' => '2020-05-01', 'is_active' => true, 'sort_order' => 1]);

        // Statistics
        Statistic::create(['label' => 'Years Experience', 'value' => 5, 'suffix' => '+', 'is_active' => true, 'sort_order' => 1]);
        Statistic::create(['label' => 'Projects Completed', 'value' => 50, 'suffix' => '+', 'is_active' => true, 'sort_order' => 2]);
        Statistic::create(['label' => 'Happy Clients', 'value' => 30, 'suffix' => '+', 'is_active' => true, 'sort_order' => 3]);
        Statistic::create(['label' => 'Technologies', 'value' => 20, 'suffix' => '+', 'is_active' => true, 'sort_order' => 4]);

        // Clients
        Client::create(['name' => 'TechCorp', 'sort_order' => 1]);
        Client::create(['name' => 'StartupXYZ', 'sort_order' => 2]);
        Client::create(['name' => 'InnovateLab', 'sort_order' => 3]);

        // Contact Settings
        ContactSetting::create([
            'email' => 'hello@johndeveloper.com',
            'phone' => '+1 (555) 123-4567',
            'whatsapp' => '+1 (555) 123-4567',
            'address' => '123 Developer Street',
            'city' => 'San Francisco',
            'state' => 'CA',
            'country' => 'USA',
            'is_active' => true,
        ]);

        // SEO Settings
        SeoSetting::create(['page' => 'home', 'meta_title' => 'John Developer | Full Stack Developer & Software Engineer', 'meta_description' => 'Professional portfolio of John Developer. Full-stack developer specializing in Laravel, Vue.js, and cloud architecture.', 'keywords' => 'developer, full stack, laravel, vue.js, web development']);
        SeoSetting::create(['page' => 'projects', 'meta_title' => 'Projects | John Developer', 'meta_description' => 'Browse my portfolio of web applications, APIs, and mobile projects.' ]);
        SeoSetting::create(['page' => 'blog', 'meta_title' => 'Blog | John Developer', 'meta_description' => 'Technical articles and tutorials about web development.' ]);
    }
}
