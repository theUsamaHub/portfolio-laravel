<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use App\Models\PageView;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->ordered()->with('category', 'author', 'tags');

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->has('search')) {
            $query->where('name', 'ilike', "%{$request->search}%");
        }

        $posts = $query->paginate(12);
        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $tags = Tag::has('posts')->orderBy('name')->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->increment('views_count');
        $post->load(['category', 'author', 'tags']);

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->ordered()
            ->limit(3)
            ->with('category', 'author')
            ->get();

        PageView::record(request()->path());

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
