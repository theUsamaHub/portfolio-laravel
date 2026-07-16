<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\HeroCta;
use App\Models\RotatingProfession;
use App\Services\MediaService;
use Illuminate\Http\Request;

class AdminHeroController extends Controller
{
    public function __construct(private MediaService $media) {}

    public function edit()
    {
        $hero = HeroSection::firstOrCreate([], ['title' => '', 'is_active' => true]);
        $hero->load(['ctas', 'professions']);
        return view('admin.content.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|max:5120',
            'background_image' => 'nullable|image|max:10240',
            'background_video' => 'nullable|file|max:51200|mimes:mp4,webm,ogg',
            'resume_file' => 'nullable|file|max:10240',
            'remove_profile_image' => 'nullable|string',
            'remove_background_image' => 'nullable|string',
            'remove_background_video' => 'nullable|string',
            'remove_resume_file' => 'nullable|string',
            'is_active' => 'boolean',
            'cta_labels' => 'nullable|array',
            'cta_urls' => 'nullable|array',
            'cta_styles' => 'nullable|array',
            'professions' => 'nullable|array',
        ]);

        $hero = HeroSection::firstOrCreate([], ['title' => '', 'is_active' => true]);

        // Handle image removals
        if (($validated['remove_profile_image'] ?? '0') === '1') {
            $this->media->delete($hero->profile_image);
            $validated['profile_image'] = null;
        } elseif ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $this->media->upload($request->file('profile_image'), 'hero');
        } else {
            unset($validated['profile_image']);
        }

        if (($validated['remove_background_image'] ?? '0') === '1') {
            $this->media->delete($hero->background_image);
            $validated['background_image'] = null;
        } elseif ($request->hasFile('background_image')) {
            $validated['background_image'] = $this->media->upload($request->file('background_image'), 'hero');
        } else {
            unset($validated['background_image']);
        }

        // Handle video
        if (($validated['remove_background_video'] ?? '0') === '1') {
            $this->media->delete($hero->background_video);
            $validated['background_video'] = null;
        } elseif ($request->hasFile('background_video')) {
            $validated['background_video'] = $this->media->upload($request->file('background_video'), 'hero');
        } else {
            unset($validated['background_video']);
        }

        // Handle resume removal
        if (($validated['remove_resume_file'] ?? '0') === '1') {
            $this->media->delete($hero->resume_file);
            $validated['resume_file'] = null;
        } elseif ($request->hasFile('resume_file')) {
            $validated['resume_file'] = $this->media->upload($request->file('resume_file'), 'hero');
        } else {
            unset($validated['resume_file']);
        }

        // Remove hidden fields from validated data
        unset($validated['remove_profile_image'], $validated['remove_background_image'], $validated['remove_background_video'], $validated['remove_resume_file']);

        $ctaLabels = $validated['cta_labels'] ?? [];
        $ctaUrls = $validated['cta_urls'] ?? [];
        $ctaStyles = $validated['cta_styles'] ?? [];
        $professions = $validated['professions'] ?? [];
        unset($validated['cta_labels'], $validated['cta_urls'], $validated['cta_styles'], $validated['professions']);

        $hero->update($validated);

        // Update CTAs
        $hero->ctas()->delete();
        foreach ($ctaLabels as $i => $label) {
            if (!empty($label) && !empty($ctaUrls[$i] ?? null)) {
                $hero->ctas()->create([
                    'label' => $label,
                    'url' => $ctaUrls[$i],
                    'style' => $ctaStyles[$i] ?? 'primary',
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }

        // Update Professions
        $hero->professions()->delete();
        foreach ($professions as $i => $profession) {
            if (!empty($profession)) {
                $hero->professions()->create([
                    'profession' => $profession,
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }

        return back()->with('success', 'Hero section updated successfully.');
    }
}
