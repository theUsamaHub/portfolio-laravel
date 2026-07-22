<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    public function __construct(
        private MediaService $media
    ) {}

    public function index(Request $request)
    {
        $query = Post::with('category', 'author', 'tags');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where('name', 'ilike', "%{$request->search}%");
        }

        $posts = $query->latest()->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'status' => 'in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->media->upload($request->file('featured_image'), 'blog');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['author_id'] = auth()->id();

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $post = Post::create($validated);
        $post->tags()->attach($tags);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $post->load('tags');
        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug,' . $post->id,
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'status' => 'in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                $validated['featured_image'] = $this->media->replace($post->featured_image, $request->file('featured_image'), 'blog');
            } else {
                $validated['featured_image'] = $this->media->upload($request->file('featured_image'), 'blog');
            }
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $post->update($validated);
        $post->tags()->sync($tags);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post deleted.');
    }
}
