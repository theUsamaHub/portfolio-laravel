<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
    <title>Forgot Password - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo"><a href="/"><h1>Portfolio CMS</h1></a><p class="text-muted" style="margin-top: 0.5rem;">Reset your password</p></div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
                <button type="submit" class="btn btn-primary w-full">Send Reset Link</button>
            </form>
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9375rem;"><a href="{{ route('login') }}">← Back to login</a></p>
        </div>
    </div>
</body>
</html>
