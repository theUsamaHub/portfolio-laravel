<?php

namespace App\Helpers;

class FallbackHelper
{
    public static function heroTitle(): string
    {
        return SettingHelper::get('hero_title', 'Backend Developer & Software Engineer');
    }

    public static function heroSubtitle(): string
    {
        return SettingHelper::get('hero_subtitle', 'I build scalable web applications and modern digital experiences.');
    }

    public static function aboutDescription(): string
    {
        return SettingHelper::get('about_description', 'A passionate software developer focused on building secure, scalable, and maintainable applications.');
    }

    public static function profession(): string
    {
        return SettingHelper::get('profession', 'Software Developer');
    }

    public static function copyright(): string
    {
        return SettingHelper::get('footer_copyright', '© ' . date('Y') . '. All Rights Reserved.');
    }

    public static function siteName(): string
    {
        return SettingHelper::get('site_name', 'Portfolio CMS');
    }
}
