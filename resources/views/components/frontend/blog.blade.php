@props(['posts'])

@if($posts->count())
<section class="vb-section" id="blog">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Blog</span>
            <h2 class="vb-section__title vb-h1">Latest Articles</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-blog__grid">
            @foreach($posts as $post)
                <article class="vb-post" data-reveal>
                    <a href="{{ route('blog.show', $post->slug) }}" class="vb-post__link">
                        <div class="vb-post__image">
                            @if($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->name }}">
                            @else
                                <div class="vb-post__placeholder">
                                    <span>{{ strtoupper(substr($post->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="vb-post__body">
                            <div class="vb-post__meta">
                                @if($post->category)
                                    <span class="vb-post__category vb-overline">{{ $post->category->name }}</span>
                                @endif
                                @if($post->published_at)
                                    <span class="vb-post__date vb-caption">{{ $post->published_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                            <h3 class="vb-post__title">{{ $post->name }}</h3>
                            @if($post->excerpt)
                                <p class="vb-post__excerpt">{{ Str::limit($post->excerpt, 120) }}</p>
                            @endif
                            <span class="vb-post__read">Read →</span>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: var(--space-2xl);" data-reveal>
            <a href="{{ route('blog.index') }}" class="vb-btn magnetic" data-cursor>View All Articles →</a>
        </div>
    </div>
</section>
@endif
