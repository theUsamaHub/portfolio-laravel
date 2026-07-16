<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
    <title>Confirm Password - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo"><a href="/"><h1>Portfolio CMS</h1></a><p class="text-muted" style="margin-top: 0.5rem;">Please confirm your password to continue.</p></div>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group"><label class="form-label">Password</label><input type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autofocus>@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
                <button type="submit" class="btn btn-primary w-full">Confirm Password</button>
            </form>
        </div>
    </div>
</body>
</html>
