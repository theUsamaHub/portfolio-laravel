@extends('layouts.voicebox')
@php
    $title = $post->meta_title ?? $post->name . ' | ' . \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $description = $post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->content), 160);
@endphp
@section('content')
@include('partials.vbox-header')
<main id="main-content" style="padding-top:4.5rem;">
    <article class="vbox-section">
        <div class="vbox-container">
            <div class="vbox-section-header vbox-reveal">
                @if($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="vbox-overline vbox-text-red" style="text-decoration:none;">&larr; {{ $post->category->name }}</a>
                @endif
                <h1 class="vbox-section-title" style="margin-top:0.75rem;">{{ $post->name }}</h1>
            </div>

            <div class="vbox-flex vbox-flex-wrap vbox-gap-4 vbox-mb-6" style="font-size:0.875rem;color:var(--vbox-text-secondary,#525252);">
                @if($post->author)<span>By {{ $post->author->name }}</span>@endif
                @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                @if($post->reading_time)<span>{{ $post->reading_time }} min read</span>@endif
                <span>{{ $post->views_count }} views</span>
            </div>

            @if($post->featured_image)
                <div class="vbox-reveal" style="margin-bottom:2rem;border:2px solid var(--vbox-border-strong,#0A0A0A);overflow:hidden;">
                    <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" style="width:100%;max-height:500px;object-fit:cover;">
                </div>
            @endif

            @if($post->tags->count())
                <div class="vbox-flex vbox-flex-wrap vbox-gap-2 vbox-mb-6">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="vbox-chip">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif

            <div class="vbox-body-lg vbox-reveal" style="line-height:1.8;">
                {!! $post->content !!}
            </div>
        </div>
    </article>

    @if($relatedPosts->count())
        <section class="vbox-section vbox-border-top" style="background:var(--vbox-bg,#FAFAFA);">
            <div class="vbox-container">
                <p class="vbox-section-overline vbox-mb-4">More Reading</p>
                <h2 class="vbox-headline">Related Articles</h2>
                <div class="vbox-blog-grid" style="margin-top:2rem;">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="vbox-blog-card">
                            @if($related->featured_image)
                                <div class="vbox-blog-image"><img src="{{ \App\Helpers\ImageHelper::url($related->featured_image, 'blog') }}" alt="{{ $related->name }}" loading="lazy"></div>
                            @endif
                            <div class="vbox-blog-body">
                                <h3 class="vbox-blog-title">{{ $related->name }}</h3>
                                <p class="vbox-blog-excerpt">{{ Str::limit(strip_tags($related->content), 100) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@include('partials.vbox-footer')
@endsection
