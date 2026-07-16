<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\Certificate;
use App\Models\Award;
use App\Models\Client;
use App\Models\Partner;
use App\Models\Statistic;
use App\Models\Tag;
use App\Models\NavigationMenu;
use App\Models\ContactSetting;
use App\Models\GalleryImage;
use App\Models\FooterSection;
use App\Models\SeoSetting;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminContentController extends Controller
{
    public function __construct(private MediaService $media) {}

    // --- TESTIMONIALS ---
    public function testimonials()
    {
        $items = Testimonial::orderBy('sort_order')->get();
        return view('admin.content.testimonials', compact('items'));
    }

    public function storeTestimonial(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'rating' => 'nullable|integer|min:1|max:5',
            'client_image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'edit_id' => 'nullable|string',
        ]);

        if ($request->hasFile('client_image')) $data['client_image'] = $this->media->upload($request->file('client_image'), 'testimonials');

        if (!empty($data['edit_id'])) {
            $item = Testimonial::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Testimonial updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Testimonial::max('sort_order') + 1;
        Testimonial::create($data);
        return back()->with('success', 'Testimonial added.');
    }

    public function destroyTestimonial(Testimonial $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- EXPERIENCES ---
    public function experiences()
    {
        $items = Experience::orderBy('sort_order')->get();
        return view('admin.content.experiences', compact('items'));
    }

    public function storeExperience(Request $request)
    {
        $data = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'company_url' => 'nullable|url|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'achievements' => 'nullable|string',
            'edit_id' => 'nullable|string',
        ]);
        if ($request->hasFile('company_logo')) $data['company_logo'] = $this->media->upload($request->file('company_logo'), 'experience');
        $data['achievements'] = array_filter(array_map('trim', explode("\n", $data['achievements'] ?? '')));

        if (!empty($data['edit_id'])) {
            $item = Experience::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Experience updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Experience::max('sort_order') + 1;
        Experience::create($data);
        return back()->with('success', 'Experience added.');
    }

    public function destroyExperience(Experience $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- EDUCATION ---
    public function educations()
    {
        $items = Education::orderBy('sort_order')->get();
        return view('admin.content.educations', compact('items'));
    }

    public function storeEducation(Request $request)
    {
        $data = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'grade' => 'nullable|string|max:50',
            'activities' => 'nullable|string|max:1000',
            'institution_logo' => 'nullable|image|max:2048',
            'edit_id' => 'nullable|string',
        ]);
        if ($request->hasFile('institution_logo')) $data['institution_logo'] = $this->media->upload($request->file('institution_logo'), 'education');

        if (!empty($data['edit_id'])) {
            $item = Education::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Education updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Education::max('sort_order') + 1;
        Education::create($data);
        return back()->with('success', 'Education added.');
    }

    public function destroyEducation(Education $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- SERVICES ---
    public function services()
    {
        $items = Service::orderBy('sort_order')->get();
        return view('admin.content.services', compact('items'));
    }

    public function storeService(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'icon' => 'nullable|string|max:255',
            'features' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'edit_id' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'] ?? '')));

        if (!empty($data['edit_id'])) {
            $item = Service::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Service updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Service::max('sort_order') + 1;
        Service::create($data);
        return back()->with('success', 'Service added.');
    }

    public function destroyService(Service $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- TAGS ---
    public function tags()
    {
        $items = Tag::withCount(['projects', 'posts'])->orderBy('name')->get();
        return view('admin.content.tags', compact('items'));
    }

    public function storeTag(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Tag::create($data);
        return back()->with('success', 'Tag created.');
    }

    public function updateTag(Request $request, Tag $item)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $item->id,
        ]);
        $data['slug'] = Str::slug($data['name']);
        $item->update($data);
        return back()->with('success', 'Tag updated.');
    }

    public function destroyTag(Tag $item)
    {
        $item->delete();
        return back()->with('success', 'Tag deleted.');
    }

    // --- SOCIAL LINKS ---
    public function socialLinks()
    {
        $items = SocialLink::orderBy('sort_order')->get();
        return view('admin.content.social-links', compact('items'));
    }

    public function storeSocialLink(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|string|max:100',
            'username' => 'nullable|string|max:255',
            'edit_id' => 'nullable|string',
        ]);

        if (!empty($data['edit_id'])) {
            $item = SocialLink::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Social link updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = SocialLink::max('sort_order') + 1;
        SocialLink::create($data);
        return back()->with('success', 'Social link added.');
    }

    public function destroySocialLink(SocialLink $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- NAVIGATION ---
    public function navigation()
    {
        $items = NavigationMenu::with('children')->whereNull('parent_id')->orderBy('sort_order')->get();
        return view('admin.content.navigation', compact('items'));
    }

    public function storeNavigation(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:navigation_menus,id',
            'open_in_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'edit_id' => 'nullable|string',
        ]);

        if (!empty($data['edit_id'])) {
            $item = NavigationMenu::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            if (isset($data['sort_order'])) $data['sort_order'] = (int) $data['sort_order'];
            $item->update($data);
            return back()->with('success', 'Navigation item updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = $data['sort_order'] ?? NavigationMenu::max('sort_order') + 1;
        NavigationMenu::create($data);
        return back()->with('success', 'Navigation item added.');
    }

    public function destroyNavigation(NavigationMenu $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- CERTIFICATES ---
    public function certificates()
    {
        $items = \App\Models\Certificate::orderBy('sort_order')->get();
        return view('admin.content.certificates', compact('items'));
    }

    public function storeCertificate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
            'edit_id' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) $data['image'] = $this->media->upload($request->file('image'), 'certificates');

        if (!empty($data['edit_id'])) {
            $item = \App\Models\Certificate::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Certificate updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = \App\Models\Certificate::max('sort_order') + 1;
        \App\Models\Certificate::create($data);
        return back()->with('success', 'Certificate added.');
    }

    public function destroyCertificate(\App\Models\Certificate $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- AWARDS ---
    public function awards()
    {
        $items = Award::orderBy('sort_order')->get();
        return view('admin.content.awards', compact('items'));
    }

    public function storeAward(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048',
            'edit_id' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) $data['image'] = $this->media->upload($request->file('image'), 'awards');

        if (!empty($data['edit_id'])) {
            $item = Award::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Award updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Award::max('sort_order') + 1;
        Award::create($data);
        return back()->with('success', 'Award added.');
    }

    public function destroyAward(Award $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- STATISTICS ---
    public function statistics()
    {
        $items = Statistic::orderBy('sort_order')->get();
        return view('admin.content.statistics', compact('items'));
    }

    public function storeStatistic(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|integer|min:0',
            'suffix' => 'nullable|string|max:10',
            'icon' => 'nullable|string|max:100',
            'edit_id' => 'nullable|string',
        ]);

        if (!empty($data['edit_id'])) {
            $item = Statistic::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Statistic updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Statistic::max('sort_order') + 1;
        Statistic::create($data);
        return back()->with('success', 'Statistic added.');
    }

    public function destroyStatistic(Statistic $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- CLIENTS ---
    public function clients()
    {
        $items = Client::orderBy('sort_order')->get();
        return view('admin.content.clients', compact('items'));
    }

    public function storeClient(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'edit_id' => 'nullable|string',
        ]);
        if ($request->hasFile('logo')) $data['logo'] = $this->media->upload($request->file('logo'), 'clients');

        if (!empty($data['edit_id'])) {
            $item = Client::findOrFail($data['edit_id']);
            unset($data['edit_id']);
            $item->update($data);
            return back()->with('success', 'Client updated.');
        }

        unset($data['edit_id']);
        $data['sort_order'] = Client::max('sort_order') + 1;
        Client::create($data);
        return back()->with('success', 'Client added.');
    }

    public function destroyClient(Client $item)
    {
        $item->delete();
        return back()->with('success', 'Deleted.');
    }

    // --- CONTACT SETTINGS ---
    public function contactSettings()
    {
        $settings = ContactSetting::firstOrCreate([], ['is_active' => true]);
        return view('admin.content.contact-settings', compact('settings'));
    }

    public function updateContactSettings(Request $request)
    {
        $data = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'map_embed_url' => 'nullable|string|max:2000',
            'working_hours' => 'nullable|string|max:500',
        ]);
        $settings = ContactSetting::firstOrCreate([], ['is_active' => true]);
        $data['working_hours'] = array_filter(array_map('trim', explode("\n", $data['working_hours'] ?? '')));
        $settings->update($data);
        return back()->with('success', 'Contact settings updated.');
    }

    // --- SEO SETTINGS ---
    public function seo()
    {
        $pages = ['home', 'projects', 'blog', 'contact', 'about', 'services'];
        $settings = [];
        foreach ($pages as $page) {
            $settings[$page] = SeoSetting::firstOrCreate(['page' => $page]);
        }
        return view('admin.content.seo', compact('settings'));
    }

    public function updateSeo(Request $request)
    {
        $validated = $request->validate([
            'pages' => 'required|array',
            'pages.*.page' => 'required|string',
            'pages.*.meta_title' => 'nullable|string|max:255',
            'pages.*.meta_description' => 'nullable|string|max:500',
            'pages.*.keywords' => 'nullable|string|max:500',
            'pages.*.og_image' => 'nullable|string|max:255',
            'pages.*.canonical_url' => 'nullable|string|max:255',
            'pages.*.robots' => 'nullable|string|max:50',
            'pages.*.og_type' => 'nullable|string|max:50',
            'pages.*.twitter_card' => 'nullable|string|max:50',
            'pages.*.schema_type' => 'nullable|string|max:50',
        ]);
        foreach ($validated['pages'] as $pageData) {
            SeoSetting::updateOrCreate(['page' => $pageData['page']], $pageData);
        }
        return back()->with('success', 'SEO settings updated.');
    }
}
