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
use App\Models\SeoSetting;
use App\Models\PageView;

class HomeController extends Controller
{
    public function index()
    {
        PageView::record(request()->path());

        $hero = HeroSection::active()->first();
        $about = AboutSection::active()->first();
        $skills = SkillCategory::active()->ordered()->with('skills')->get();
        $services = Service::active()->ordered()->get();
        $projects = Project::published()->featured()->ordered()->limit(6)->with('category', 'technologies')->get();
        $posts = Post::published()->ordered()->limit(3)->with('category', 'author')->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $experiences = Experience::active()->ordered()->get();
        $educations = Education::active()->ordered()->get();
        $statistics = Statistic::active()->ordered()->get();
        $clients = Client::active()->ordered()->get();
        $contact = ContactSetting::active()->first();

        return view('vbox-home', compact(
            'hero', 'about', 'skills', 'services', 'projects', 'posts',
            'testimonials', 'experiences', 'educations', 'statistics',
            'clients', 'contact'
        ));
    }
}
