<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProjectController extends Controller
{
    public function __construct(
        private MediaService $media
    ) {}

    public function index(Request $request)
    {
        $query = Project::with('category', 'tags');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'ilike', "%{$search}%");
        }

        $projects = $query->latest()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = ProjectCategory::active()->ordered()->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.projects.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'project_category_id' => 'nullable|exists:project_categories,id',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:5120',
            'status' => 'in:draft,published,archived',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->media->upload($request->file('thumbnail'), 'projects');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['views_count'] = 0;

        $tags = $validated['tags'] ?? [];
        $technologies = $validated['technologies'] ?? [];
        unset($validated['tags'], $validated['technologies']);

        $project = Project::create($validated);

        if ($tags) {
            $project->tags()->attach($tags);
        }

        foreach ($technologies as $index => $tech) {
            $project->technologies()->create([
                'name' => $tech,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $project->load(['tags', 'technologies', 'gallery']);
        $categories = ProjectCategory::active()->ordered()->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'categories', 'tags'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'project_category_id' => 'nullable|exists:project_categories,id',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:5120',
            'status' => 'in:draft,published,archived',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->media->replace($project->thumbnail, $request->file('thumbnail'), 'projects');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $tags = $validated['tags'] ?? [];
        $technologies = $validated['technologies'] ?? [];
        unset($validated['tags'], $validated['technologies']);

        $project->update($validated);
        $project->tags()->sync($tags);
        $project->technologies()->delete();
        foreach ($technologies as $index => $tech) {
            $project->technologies()->create(['name' => $tech, 'sort_order' => $index]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }
}
