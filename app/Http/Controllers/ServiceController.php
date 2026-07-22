<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SocialLink;
use App\Models\NavigationMenu;
use App\Models\ContactSetting;
use App\Models\SiteSetting;

class ServiceController extends Controller
{
    private function sharedData(): array
    {
        $navigation = NavigationMenu::active()->topLevel()->ordered()->with('children')->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        $contact = ContactSetting::active()->first();

        $settings = [
            'site_name'        => SiteSetting::get('site_name', 'Portfolio'),
            'site_tagline'     => SiteSetting::get('site_tagline', ''),
            'site_description' => SiteSetting::get('site_description', ''),
            'site_email'       => SiteSetting::get('site_email', ''),
            'footer_copyright' => SiteSetting::get('footer_copyright', ''),
        ];

        return compact('navigation', 'socialLinks', 'contact', 'settings');
    }

    public function index()
    {
        $services = Service::active()->ordered()->get();

        return view('frontend.services.index', array_merge($this->sharedData(), compact('services')));
    }

    public function show(Service $service)
    {
        $service->load([]);

        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->ordered()
            ->limit(3)
            ->get();

        return view('frontend.services.show', array_merge($this->sharedData(), compact('service', 'relatedServices')));
    }
}
