<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Usama Developer', 'type' => 'text', 'group' => 'general', 'sort_order' => 0],
            ['key' => 'site_tagline', 'value' => 'Full Stack Developer & Software Engineer', 'type' => 'text', 'group' => 'general', 'sort_order' => 1],
            ['key' => 'site_description', 'value' => 'I build scalable web applications and modern digital experiences.', 'type' => 'text', 'group' => 'general', 'sort_order' => 2],
            ['key' => 'site_keywords', 'value' => 'developer, full stack, laravel, vue.js, web development, portfolio', 'type' => 'text', 'group' => 'general', 'sort_order' => 3],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'sort_order' => 4],
            ['key' => 'site_favicon', 'value' => '/favicon.svg', 'type' => 'text', 'group' => 'general', 'sort_order' => 5],
            ['key' => 'site_author', 'value' => 'Usama Developer', 'type' => 'text', 'group' => 'general', 'sort_order' => 6],
            ['key' => 'site_currency', 'value' => 'USD', 'type' => 'text', 'group' => 'general', 'sort_order' => 7],
            ['key' => 'site_locale', 'value' => 'en', 'type' => 'text', 'group' => 'general', 'sort_order' => 8],
            ['key' => 'site_timezone', 'value' => 'UTC', 'type' => 'text', 'group' => 'general', 'sort_order' => 9],

            // Appearance
            ['key' => 'primary_color', 'value' => '#2563EB', 'type' => 'color', 'group' => 'appearance', 'sort_order' => 0],
            ['key' => 'secondary_color', 'value' => '#7C3AED', 'type' => 'color', 'group' => 'appearance', 'sort_order' => 1],
            ['key' => 'accent_color', 'value' => '#06B6D4', 'type' => 'color', 'group' => 'appearance', 'sort_order' => 2],
            ['key' => 'default_theme', 'value' => 'light', 'type' => 'text', 'group' => 'appearance', 'sort_order' => 3],
            ['key' => 'custom_css', 'value' => '', 'type' => 'text', 'group' => 'appearance', 'sort_order' => 4],
            ['key' => 'custom_js', 'value' => '', 'type' => 'text', 'group' => 'appearance', 'sort_order' => 5],

            // Contact
            ['key' => 'contact_email', 'value' => 'hello@usama.dev', 'type' => 'text', 'group' => 'contact', 'sort_order' => 0],
            ['key' => 'contact_phone', 'value' => '', 'type' => 'text', 'group' => 'contact', 'sort_order' => 1],
            ['key' => 'contact_whatsapp', 'value' => '', 'type' => 'text', 'group' => 'contact', 'sort_order' => 2],
            ['key' => 'contact_address', 'value' => '', 'type' => 'text', 'group' => 'contact', 'sort_order' => 3],
            ['key' => 'contact_map_embed', 'value' => '', 'type' => 'text', 'group' => 'contact', 'sort_order' => 4],

            // Footer
            ['key' => 'footer_copyright', 'value' => '© 2025 Usama Developer. All Rights Reserved.', 'type' => 'text', 'group' => 'footer', 'sort_order' => 0],
            ['key' => 'footer_tagline', 'value' => 'Building digital experiences that matter.', 'type' => 'text', 'group' => 'footer', 'sort_order' => 1],
            ['key' => 'footer_show_social', 'value' => '1', 'type' => 'boolean', 'group' => 'footer', 'sort_order' => 2],

            // Analytics
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'sort_order' => 0],
            ['key' => 'google_tag_manager', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'sort_order' => 1],
            ['key' => 'facebook_pixel', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'sort_order' => 2],
            ['key' => 'hotjar_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'sort_order' => 3],

            // Email
            ['key' => 'smtp_host', 'value' => '', 'type' => 'text', 'group' => 'email', 'sort_order' => 0],
            ['key' => 'smtp_port', 'value' => '587', 'type' => 'text', 'group' => 'email', 'sort_order' => 1],
            ['key' => 'smtp_username', 'value' => '', 'type' => 'text', 'group' => 'email', 'sort_order' => 2],
            ['key' => 'smtp_password', 'value' => '', 'type' => 'text', 'group' => 'email', 'sort_order' => 3],
            ['key' => 'smtp_encryption', 'value' => 'tls', 'type' => 'text', 'group' => 'email', 'sort_order' => 4],
            ['key' => 'email_from_name', 'value' => 'Portfolio', 'type' => 'text', 'group' => 'email', 'sort_order' => 5],
            ['key' => 'email_from_address', 'value' => 'noreply@usama.dev', 'type' => 'text', 'group' => 'email', 'sort_order' => 6],

            // Security
            ['key' => 'enable_recaptcha', 'value' => '0', 'type' => 'boolean', 'group' => 'security', 'sort_order' => 0],
            ['key' => 'enable_hsts', 'value' => '1', 'type' => 'boolean', 'group' => 'security', 'sort_order' => 1],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'security', 'sort_order' => 2],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
