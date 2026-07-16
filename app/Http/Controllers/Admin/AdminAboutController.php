<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Services\MediaService;
use Illuminate\Http\Request;

class AdminAboutController extends Controller
{
    public function __construct(private MediaService $media) {}

    public function edit()
    {
        $about = AboutSection::firstOrCreate([], ['title' => 'About Me', 'description' => '', 'is_active' => true]);
        return view('admin.content.about', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'highlights' => 'nullable|string',
            'profile_image' => 'nullable|image|max:5120',
            'experience_years' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'languages' => 'nullable|string',
            'cv_file' => 'nullable|file|max:10240',
            'remove_profile_image' => 'nullable|string',
            'remove_cv_file' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $about = AboutSection::firstOrCreate([], ['title' => 'About Me', 'description' => '', 'is_active' => true]);

        // Handle profile image removal
        if (($validated['remove_profile_image'] ?? '0') === '1') {
            $this->media->delete($about->profile_image);
            $validated['profile_image'] = null;
        } elseif ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $this->media->upload($request->file('profile_image'), 'about');
        } else {
            unset($validated['profile_image']);
        }

        // Handle CV file removal
        if (($validated['remove_cv_file'] ?? '0') === '1') {
            $this->media->delete($about->cv_file);
            $validated['cv_file'] = null;
        } elseif ($request->hasFile('cv_file')) {
            $validated['cv_file'] = $this->media->upload($request->file('cv_file'), 'about');
        } else {
            unset($validated['cv_file']);
        }

        unset($validated['remove_profile_image'], $validated['remove_cv_file']);

        $validated['highlights'] = array_filter(array_map('trim', explode("\n", $validated['highlights'] ?? '')));
        $validated['languages'] = array_filter(array_map('trim', explode("\n", $validated['languages'] ?? '')));

        $about->update($validated);

        return back()->with('success', 'About section updated successfully.');
    }
}
