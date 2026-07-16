<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Tag;
use App\Models\PageView;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::published()->ordered()->with('category', 'technologies', 'tags');

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->has('search')) {
            $query->where('name', 'ilike', "%{$request->search}%");
        }

        $projects = $query->paginate(12);
        $categories = ProjectCategory::active()->ordered()->get();
        $tags = Tag::has('projects')->orderBy('name')->get();

        return view('projects.index', compact('projects', 'categories', 'tags'));
    }

    public function show(Project $project)
    {
        if ($project->status !== 'published') {
            abort(404);
        }

        $project->increment('views_count');
        $project->load(['category', 'technologies', 'tags', 'gallery']);

        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where('project_category_id', $project->project_category_id)
            ->ordered()
            ->limit(3)
            ->with('category', 'technologies')
            ->get();

        PageView::record(request()->path());

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
