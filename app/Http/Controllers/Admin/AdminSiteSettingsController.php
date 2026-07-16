<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\MediaService;
use App\Helpers\AuthRouteHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminSiteSettingsController extends Controller
{
    public function __construct(
        private MediaService $media
    ) {}

    public function index()
    {
        $groups = DB::table('site_settings')
            ->selectRaw('"group", count(*) as count')
            ->groupByRaw('"group"')
            ->pluck('count', 'group');

        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string'],
            'settings.*.value' => ['nullable', 'string'],
        ]);

        foreach ($validated['settings'] as $item) {
            SiteSetting::set($item['key'], $item['value']);
        }

        Cache::flush();

        return back()->with('success', 'Settings updated successfully.');
    }

    public function group(string $group)
    {
        $settings = SiteSetting::where('group', $group)->orderBy('sort_order')->get();

        return view('admin.settings.group', compact('settings', 'group'));
    }

    public function updateGroup(Request $request, string $group)
    {
        foreach ($request->input('settings', []) as $key => $value) {
            SiteSetting::set($key, $value);
        }

        Cache::flush();

        return back()->with('success', ucfirst(str_replace('_', ' ', $group)) . ' settings updated.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
            'key' => ['required', 'string'],
        ]);

        $path = $this->media->upload($request->file('file'), 'settings');
        SiteSetting::set($request->input('key'), $path, 'image');

        return response()->json(['path' => $path, 'url' => asset('storage/' . $path)]);
    }

    public function authRoutes()
    {
        $routes = AuthRouteHelper::getAllPaths();
        return view('admin.settings.auth-routes', compact('routes'));
    }

    public function updateAuthRoutes(Request $request)
    {
        $validated = $request->validate([
            'login_path' => 'required|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
            'register_path' => 'required|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
            'forgot_password_path' => 'required|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
            'reset_password_path' => 'required|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
        ]);

        // Check for duplicates
        $paths = array_values($validated);
        if (count($paths) !== count(array_unique($paths))) {
            return back()->withErrors(['login_path' => 'All routes must be unique.'])->withInput();
        }

        SiteSetting::set('auth_login_path', $validated['login_path']);
        SiteSetting::set('auth_register_path', $validated['register_path']);
        SiteSetting::set('auth_forgot_password_path', $validated['forgot_password_path']);
        SiteSetting::set('auth_reset_password_path', $validated['reset_password_path']);

        AuthRouteHelper::clearCache();

        return back()->with('success', 'Auth routes updated. New URLs will be active after cache clears.');
    }
}
