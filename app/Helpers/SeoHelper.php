<?php

namespace App\Helpers;

use App\Models\SeoSetting;
use Illuminate\Support\Facades\Cache;

class SeoHelper
{
    public static function get(string $page): array
    {
        $seo = Cache::remember("seo_{$page}", 3600, function () use ($page) {
            $model = SeoSetting::where('page', $page)->first();
            return $model ? $model->toArray() : null;
        });

        $siteName = SettingHelper::get('site_name', 'Portfolio');

        return [
            'title' => ($seo['meta_title'] ?? null) ?? self::defaultTitle($page, $siteName),
            'description' => ($seo['meta_description'] ?? null) ?? self::defaultDescription($page),
            'keywords' => $seo['keywords'] ?? SettingHelper::get('site_keywords', ''),
            'og_image' => !empty($seo['og_image']) ? asset('storage/' . $seo['og_image']) : asset('favicon.svg'),
            'og_type' => $seo['og_type'] ?? 'website',
            'canonical' => $seo['canonical_url'] ?? url()->current(),
            'robots' => $seo['robots'] ?? 'index,follow',
            'twitter_card' => $seo['twitter_card'] ?? 'summary_large_image',
            'schema_type' => $seo['schema_type'] ?? null,
        ];
    }

    public static function renderMeta(string $page): string
    {
        $seo = self::get($page);
        $siteName = SettingHelper::get('site_name', 'Portfolio');

        $html = '';
        $html .= "    <title>{$seo['title']}</title>\n";
        $html .= "    <meta name=\"description\" content=\"" . e($seo['description']) . "\">\n";
        if ($seo['keywords']) {
            $html .= "    <meta name=\"keywords\" content=\"" . e($seo['keywords']) . "\">\n";
        }
        $html .= "    <meta name=\"robots\" content=\"{$seo['robots']}\">\n";
        $html .= "    <link rel=\"canonical\" href=\"{$seo['canonical']}\">\n";

        // Open Graph
        $html .= "    <meta property=\"og:title\" content=\"" . e($seo['title']) . "\">\n";
        $html .= "    <meta property=\"og:description\" content=\"" . e($seo['description']) . "\">\n";
        $html .= "    <meta property=\"og:image\" content=\"{$seo['og_image']}\">\n";
        $html .= "    <meta property=\"og:url\" content=\"{$seo['canonical']}\">\n";
        $html .= "    <meta property=\"og:type\" content=\"{$seo['og_type']}\">\n";
        $html .= "    <meta property=\"og:site_name\" content=\"" . e($siteName) . "\">\n";

        // Twitter Card
        $html .= "    <meta name=\"twitter:card\" content=\"{$seo['twitter_card']}\">\n";
        $html .= "    <meta name=\"twitter:title\" content=\"" . e($seo['title']) . "\">\n";
        $html .= "    <meta name=\"twitter:description\" content=\"" . e($seo['description']) . "\">\n";
        $html .= "    <meta name=\"twitter:image\" content=\"{$seo['og_image']}\">\n";

        return $html;
    }

    public static function renderSchema(string $page): string
    {
        $seo = self::get($page);
        $siteName = SettingHelper::get('site_name', 'Portfolio');
        $siteUrl = url('/');

        if (empty($seo['schema_type'])) return '';

        $schema = match($seo['schema_type']) {
            'WebPage' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $seo['title'],
                'description' => $seo['description'],
                'url' => $seo['canonical'],
                'publisher' => ['@type' => 'Organization', 'name' => $siteName],
            ],
            'Article' => [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $seo['title'],
                'description' => $seo['description'],
                'url' => $seo['canonical'],
                'author' => ['@type' => 'Person', 'name' => SettingHelper::get('site_author', $siteName)],
                'publisher' => ['@type' => 'Organization', 'name' => $siteName],
            ],
            'Person' => [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $siteName,
                'url' => $siteUrl,
                'jobTitle' => SettingHelper::get('site_tagline', ''),
            ],
            'Organization' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $siteName,
                'url' => $siteUrl,
            ],
            'BreadcrumbList' => [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $siteUrl],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $seo['title'], 'item' => $seo['canonical']],
                ],
            ],
            default => null,
        };

        if (!$schema) return '';

        return "    <script type=\"application/ld+json\">" . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
    }

    private static function defaultTitle(string $page, string $siteName): string
    {
        return match ($page) {
            'home' => $siteName . ' | ' . SettingHelper::get('site_tagline', 'Developer'),
            default => $siteName . ' - ' . ucfirst(str_replace('_', ' ', $page)),
        };
    }

    private static function defaultDescription(string $page): string
    {
        return SettingHelper::get('site_description', 'Professional portfolio showcasing projects, skills, and experience.');
    }
}
