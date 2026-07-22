<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\SkillCategory;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Statistic;
use App\Models\SocialLink;
use App\Models\NavigationMenu;
use App\Models\ContactSetting;
use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutSection::active()->first();
        $skillCategories = SkillCategory::active()->ordered()->with('skills')->get();
        $experiences = Experience::active()->ordered()->get();
        $educations = Education::active()->ordered()->get();
        $statistics = Statistic::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        $navigation = NavigationMenu::active()->topLevel()->ordered()->with('children')->get();
        $contact = ContactSetting::active()->first();

        $settings = [
            'site_name'        => SiteSetting::get('site_name', 'Portfolio'),
            'site_tagline'     => SiteSetting::get('site_tagline', ''),
            'site_description' => SiteSetting::get('site_description', ''),
            'site_email'       => SiteSetting::get('site_email', ''),
            'footer_copyright' => SiteSetting::get('footer_copyright', ''),
        ];

        return view('frontend.about', compact(
            'about', 'skillCategories', 'experiences', 'educations',
            'statistics', 'socialLinks', 'navigation', 'contact', 'settings'
        ));
    }
}
