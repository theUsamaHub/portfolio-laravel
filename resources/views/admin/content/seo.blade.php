@extends('layouts.admin')
@section('admin-content')
<div class="mb-6">
    <h2 style="font-size: 1.25rem; font-weight: 700;">SEO Settings</h2>
    <p class="text-muted" style="font-size:0.875rem;">Configure meta tags, Open Graph, Twitter Cards, and robots for each page.</p>
</div>

<form method="POST" action="{{ route('admin.seo.update') }}">
    @csrf
    @foreach($settings as $page => $seo)
        <div class="card mb-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="badge badge-sm badge-primary" style="text-transform:capitalize;">{{ $page }}</span>
                <h3 style="font-weight: 600; text-transform:capitalize;">{{ str_replace('_', ' ', $page) }} Page</h3>
            </div>
            <input type="hidden" name="pages[{{ $page }}][page]" value="{{ $page }}">

            {{-- Meta Tags --}}
            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-input" name="pages[{{ $page }}][meta_title]" value="{{ $seo->meta_title ?? '' }}" maxlength="255" placeholder="Page title for search engines (50-60 chars recommended)">
                <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Recommended: 50-60 characters. This appears as the clickable headline in search results.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea class="form-textarea" name="pages[{{ $page }}][meta_description]" rows="2" maxlength="500" placeholder="Brief description for search engines (150-160 chars recommended)">{{ $seo->meta_description ?? '' }}</textarea>
                <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Recommended: 150-160 characters. This appears below the title in search results.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Keywords</label>
                <input type="text" class="form-input" name="pages[{{ $page }}][keywords]" value="{{ $seo->keywords ?? '' }}" placeholder="keyword1, keyword2, keyword3">
                <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Comma-separated. Used for meta keywords tag (less important for modern SEO but still useful).</p>
            </div>

            {{-- Open Graph --}}
            <h4 style="font-weight: 600; font-size: 0.9375rem; margin: 1.5rem 0 0.75rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">Open Graph (Facebook/LinkedIn)</h4>

            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label">OG Image URL</label>
                    <input type="text" class="form-input" name="pages[{{ $page }}][og_image]" value="{{ $seo->og_image ?? '' }}" placeholder="https://example.com/image.jpg">
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Recommended: 1200x630 pixels. Full URL required.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">OG Type</label>
                    <select class="form-select" name="pages[{{ $page }}][og_type]">
                        <option value="website" {{ ($seo->og_type ?? 'website') === 'website' ? 'selected' : '' }}>Website</option>
                        <option value="article" {{ ($seo->og_type ?? '') === 'article' ? 'selected' : '' }}>Article</option>
                        <option value="profile" {{ ($seo->og_type ?? '') === 'profile' ? 'selected' : '' }}>Profile</option>
                        <option value="product" {{ ($seo->og_type ?? '') === 'product' ? 'selected' : '' }}>Product</option>
                    </select>
                </div>
            </div>

            {{-- Twitter Card --}}
            <h4 style="font-weight: 600; font-size: 0.9375rem; margin: 1.5rem 0 0.75rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">Twitter Card</h4>

            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Card Type</label>
                    <select class="form-select" name="pages[{{ $page }}][twitter_card]">
                        <option value="summary_large_image" {{ ($seo->twitter_card ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                        <option value="summary" {{ ($seo->twitter_card ?? '') === 'summary' ? 'selected' : '' }}>Summary</option>
                    </select>
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Summary Large Image shows a large preview. Summary shows a small thumbnail.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Canonical URL</label>
                    <input type="text" class="form-input" name="pages[{{ $page }}][canonical_url]" value="{{ $seo->canonical_url ?? '' }}" placeholder="https://example.com/page">
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Leave empty to use current page URL. Used to prevent duplicate content issues.</p>
                </div>
            </div>

            {{-- Robots --}}
            <h4 style="font-weight: 600; font-size: 0.9375rem; margin: 1.5rem 0 0.75rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">Robots & Indexing</h4>

            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Robots</label>
                    <select class="form-select" name="pages[{{ $page }}][robots]">
                        <option value="index,follow" {{ ($seo->robots ?? 'index,follow') === 'index,follow' ? 'selected' : '' }}>Index, Follow (Default)</option>
                        <option value="noindex,follow" {{ ($seo->robots ?? '') === 'noindex,follow' ? 'selected' : '' }}>No Index, Follow</option>
                        <option value="index,nofollow" {{ ($seo->robots ?? '') === 'index,nofollow' ? 'selected' : '' }}>Index, No Follow</option>
                        <option value="noindex,nofollow" {{ ($seo->robots ?? '') === 'noindex,nofollow' ? 'selected' : '' }}>No Index, No Follow</option>
                    </select>
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Index tells search engines to include this page. Follow allows them to follow links on this page.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Schema Markup Type</label>
                    <select class="form-select" name="pages[{{ $page }}][schema_type]">
                        <option value="" {{ empty($seo->schema_type) ? 'selected' : '' }}>None</option>
                        <option value="WebPage" {{ ($seo->schema_type ?? '') === 'WebPage' ? 'selected' : '' }}>WebPage</option>
                        <option value="Article" {{ ($seo->schema_type ?? '') === 'Article' ? 'selected' : '' }}>Article</option>
                        <option value="Person" {{ ($seo->schema_type ?? '') === 'Person' ? 'selected' : '' }}>Person</option>
                        <option value="Organization" {{ ($seo->schema_type ?? '') === 'Organization' ? 'selected' : '' }}>Organization</option>
                        <option value="BreadcrumbList" {{ ($seo->schema_type ?? '') === 'BreadcrumbList' ? 'selected' : '' }}>BreadcrumbList</option>
                        <option value="Product" {{ ($seo->schema_type ?? '') === 'Product' ? 'selected' : '' }}>Product</option>
                        <option value="FAQPage" {{ ($seo->schema_type ?? '') === 'FAQPage' ? 'selected' : '' }}>FAQPage</option>
                    </select>
                    <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Structured data helps search engines understand your content better.</p>
                </div>
            </div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Save All SEO Settings</button>
</form>
@endsection
