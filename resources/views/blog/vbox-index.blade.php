@extends('layouts.voicebox')
@section('content')
@include('partials.vbox-header')
<main id="main-content" style="padding-top:4.5rem;">
    <section class="vbox-section">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                <p class="vbox-section-overline">Writing</p>
                <h1 class="vbox-section-title">Latest Articles</h1>
            </div>

            <div class="vbox-blog-grid">
                @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="vbox-blog-card vbox-stagger-child">
                        @if($post->featured_image)
                            <div class="vbox-blog-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vbox-blog-body">
                            <div class="vbox-blog-meta">
                                @if($post->category)<span>{{ $post->category->name }}</span>@endif
                                <span>{{ $post->published_at?->diffForHumans() }}</span>
                                @if($post->reading_time)<span>{{ $post->reading_time }} min read</span>@endif
                            </div>
                            <h3 class="vbox-blog-title">{{ $post->name }}</h3>
                            <p class="vbox-blog-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                        </div>
                    </a>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:4rem 0;">
                        <p class="vbox-headline">No Articles Yet</p>
                        <p class="vbox-body-sm vbox-text-secondary" style="margin-top:0.5rem;">Check back soon for new content.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $posts->withQueryString()->links() }}</div>
        </div>
    </section>
</main>
@include('partials.vbox-footer')
@endsection
