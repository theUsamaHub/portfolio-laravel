<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\NavigationMenu;
use App\Models\SocialLink;
use App\Models\ContactSetting;
use App\Models\SiteSetting;

class BlogController extends Controller
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
        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();

        $posts = Post::published()
            ->ordered()
            ->with(['category', 'tags', 'author'])
            ->paginate(9)
            ->withQueryString();

        return view('frontend.blog.index', array_merge($this->sharedData(), compact('posts', 'categories')));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $post->load(['category', 'tags', 'author']);

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(5)
            ->get();

        $recentPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('frontend.blog.show', array_merge($this->sharedData(), compact('post', 'relatedPosts', 'recentPosts')));
    }
}
