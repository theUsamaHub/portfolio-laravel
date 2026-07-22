<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Tag;
use App\Models\SocialLink;
use App\Models\NavigationMenu;
use App\Models\ContactSetting;
use App\Models\SiteSetting;

class ProjectController extends Controller
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
        $categories = ProjectCategory::active()->ordered()->withCount('projects')->get();
        $tags = Tag::whereHas('projects', fn($q) => $q->published())->withCount('projects')->orderBy('name')->get();

        $projects = Project::published()
            ->ordered()
            ->with(['category', 'technologies', 'tags'])
            ->paginate(9)
            ->withQueryString();

        return view('frontend.projects.index', array_merge($this->sharedData(), compact('projects', 'categories', 'tags')));
    }

    public function show(Project $project)
    {
        abort_unless($project->status === 'published', 404);

        $project->load(['category', 'technologies', 'tags', 'gallery']);

        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where('project_category_id', $project->project_category_id)
            ->with(['category', 'technologies'])
            ->ordered()
            ->limit(3)
            ->get();

        if ($relatedProjects->count() < 3) {
            $more = Project::published()
                ->where('id', '!=', $project->id)
                ->whereNotIn('id', $relatedProjects->pluck('id')->push($project->id))
                ->with(['category', 'technologies'])
                ->ordered()
                ->limit(3 - $relatedProjects->count())
                ->get();
            $relatedProjects = $relatedProjects->concat($more);
        }

        return view('frontend.projects.show', array_merge($this->sharedData(), compact('project', 'relatedProjects')));
    }
}
