<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSkillController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::with('skills')->ordered()->get();
        return view('admin.content.skills', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        SkillCategory::create($validated);
        return back()->with('success', 'Category created.');
    }

    public function updateCategory(Request $request, SkillCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);
        return back()->with('success', 'Category updated.');
    }

    public function destroyCategory(SkillCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        Skill::create($validated);
        return back()->with('success', 'Skill added.');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $skill->update($validated);
        return back()->with('success', 'Skill updated.');
    }

    public function destroySkill(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }
}
