<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\SkillCategory;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Statistic;
use App\Models\Client;
use App\Models\ContactSetting;
use App\Models\SocialLink;
use App\Models\NavigationMenu;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $hero = HeroSection::active()->first();
        $about = AboutSection::active()->first();

        $skillCategories = SkillCategory::active()->ordered()->with('skills')->get();
        $services = Service::active()->ordered()->get();
        $projects = Project::published()->featured()->ordered()->with(['category', 'technologies', 'tags'])->limit(5)->get();
        $posts = Post::published()->ordered()->with(['category', 'tags', 'author'])->limit(5)->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $experiences = Experience::active()->ordered()->get();
        $educations = Education::active()->ordered()->get();
        $statistics = Statistic::active()->ordered()->get();
        $clients = Client::active()->ordered()->get();
        $contact = ContactSetting::active()->first();
        $socialLinks = SocialLink::active()->ordered()->get();
        $navigation = NavigationMenu::active()->topLevel()->ordered()->with('children')->get();

        $settings = [
            'site_name' => SiteSetting::get('site_name', 'Portfolio'),
            'site_tagline' => SiteSetting::get('site_tagline', ''),
            'site_description' => SiteSetting::get('site_description', ''),
            'site_email' => SiteSetting::get('site_email', ''),
            'site_phone' => SiteSetting::get('site_phone', ''),
            'site_address' => SiteSetting::get('site_address', ''),
            'footer_copyright' => SiteSetting::get('footer_copyright', ''),
            'primary_color' => SiteSetting::get('primary_color', '#0A0A0A'),
            'secondary_color' => SiteSetting::get('secondary_color', '#EF4444'),
        ];

        return view('frontend.home', compact(
            'hero', 'about', 'skillCategories', 'services', 'projects',
            'posts', 'testimonials', 'experiences', 'educations',
            'statistics', 'clients', 'contact', 'socialLinks',
            'navigation', 'settings'
        ));
    }
}
