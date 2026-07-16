@extends('layouts.admin')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700;">{{ ucfirst(str_replace('_', ' ', $group)) }} Settings</h2>
        <p class="text-muted" style="font-size:0.875rem;">{{ count($settings) }} settings configured</p>
    </div>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-ghost btn-sm">Back to Settings</a>
</div>

<form method="POST" action="{{ route('admin.settings.group.update', $group) }}">
    @csrf
    <div class="card">
        @php
        $fieldHelp = [
            'site_name' => 'Your name or brand name displayed across the site',
            'site_tagline' => 'Short tagline displayed under your name',
            'site_description' => 'Brief description for SEO and site header',
            'site_keywords' => 'Comma-separated keywords for SEO',
            'site_logo' => 'Upload your logo (PNG, SVG recommended)',
            'site_favicon' => 'Browser tab icon (SVG, ICO, or PNG)',
            'site_author' => 'Author name for meta tags',
            'site_currency' => 'Currency code for pricing (USD, EUR, GBP)',
            'site_locale' => 'Site language (en, es, fr, de)',
            'site_timezone' => 'Your timezone (UTC, America/New_York, etc)',
            'primary_color' => 'Main brand color used for buttons and links',
            'secondary_color' => 'Secondary accent color',
            'accent_color' => 'Highlight color for accents',
            'default_theme' => 'Default theme when user visits (light/dark)',
            'custom_css' => 'Additional CSS rules (advanced)',
            'custom_js' => 'Additional JavaScript code (advanced)',
            'contact_email' => 'Email address displayed on contact page',
            'contact_phone' => 'Phone number displayed on contact page',
            'contact_whatsapp' => 'WhatsApp number for direct messaging',
            'contact_address' => 'Physical address for contact page',
            'contact_map_embed' => 'Google Maps embed URL for contact page',
            'footer_copyright' => 'Copyright text in footer',
            'footer_tagline' => 'Tagline text in footer',
            'footer_show_social' => 'Show social media icons in footer',
            'google_analytics_id' => 'Google Analytics Measurement ID (G-XXXXXXXXXX)',
            'google_tag_manager' => 'Google Tag Manager container ID (GTM-XXXXXXX)',
            'facebook_pixel' => 'Facebook Pixel ID for tracking',
            'hotjar_id' => 'Hotjar site ID for heatmaps',
            'smtp_host' => 'SMTP server hostname (smtp.gmail.com)',
            'smtp_port' => 'SMTP port (587 for TLS, 465 for SSL)',
            'smtp_username' => 'SMTP username or email',
            'smtp_password' => 'SMTP password or app password',
            'smtp_encryption' => 'Encryption type (tls or ssl)',
            'email_from_name' => 'Sender name for outgoing emails',
            'email_from_address' => 'Sender email address',
            'enable_recaptcha' => 'Enable Google reCAPTCHA on contact form',
            'enable_hsts' => 'Enable HTTP Strict Transport Security',
            'maintenance_mode' => 'Put site in maintenance mode',
        ];
        @endphp

        @forelse($settings as $setting)
            <div class="form-group" style="padding: 1rem 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                <div class="flex justify-between items-start gap-4" style="flex-wrap:wrap;">
                    <div style="flex:1;min-width:200px;">
                        <label class="form-label" style="font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                        @if(isset($fieldHelp[$setting->key]))
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.125rem; margin-bottom: 0.5rem;">{{ $fieldHelp[$setting->key] }}</p>
                        @endif
                    </div>
                    <div style="flex:2;min-width:250px;">
                        @if($setting->type === 'text')
                            <input type="text" class="form-input" name="settings[{{ $setting->key }}]" value="{{ old("settings.{$setting->key}", $setting->value ?? '') }}" placeholder="{{ ucfirst(str_replace('_', ' ', $setting->key)) }}">
                        @elseif($setting->type === 'color')
                            <div class="flex items-center gap-2">
                                <input type="color" name="settings[{{ $setting->key }}]" value="{{ old("settings.{$setting->key}", $setting->value ?? '#000000') }}" style="width:3rem;height:2.5rem;border:1px solid var(--border-color);border-radius:var(--radius);cursor:pointer;">
                                <input type="text" class="form-input" value="{{ old("settings.{$setting->key}", $setting->value ?? '') }}" style="flex:1;" readonly>
                            </div>
                        @elseif($setting->type === 'boolean')
                            <select class="form-select" name="settings[{{ $setting->key }}]">
                                <option value="1" {{ old("settings.{$setting->key}", $setting->value) ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ !old("settings.{$setting->key}", $setting->value) ? 'selected' : '' }}>Disabled</option>
                            </select>
                        @elseif($setting->type === 'json')
                            <textarea class="form-textarea" name="settings[{{ $setting->key }}]" rows="3">{{ is_array($setting->value) ? json_encode($setting->value, JSON_PRETTY_PRINT) : ($setting->value ?? '') }}</textarea>
                        @elseif($setting->type === 'image')
                            <input type="file" class="form-input" name="settings[{{ $setting->key }}]" accept="image/*">
                            @if($setting->value)
                                <div style="margin-top:0.5rem;display:flex;align-items:center;gap:0.5rem;">
                                    <img src="{{ asset('storage/'.$setting->value) }}" style="max-height:40px;border-radius:var(--radius);border:1px solid var(--border-color);">
                                    <span style="font-size:0.75rem;color:var(--text-muted);">Current image</span>
                                </div>
                            @endif
                        @else
                            <textarea class="form-textarea" name="settings[{{ $setting->key }}]" rows="3">{{ old("settings.{$setting->key}", $setting->value ?? '') }}</textarea>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p class="empty-state-title">No settings in this group</p>
                <p class="empty-state-description">Settings will appear here once added to the database.</p>
            </div>
        @endforelse

        @if($settings->count())
            <div style="padding-top:1rem;border-top:1px solid var(--border-color);margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Save {{ ucfirst(str_replace('_', ' ', $group)) }} Settings</button>
            </div>
        @endif
    </div>
</form>
@endsection
