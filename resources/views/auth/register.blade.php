<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Register - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo"><a href="/"><h1>Portfolio CMS</h1></a><p class="text-muted" style="margin-top: 0.5rem;">Create an account</p></div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group"><label class="form-label">Name</label><input type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="form-label">Password</label><input type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="form-label">Confirm Password</label><input type="password" class="form-input" name="password_confirmation" required></div>
                <button type="submit" class="btn btn-primary w-full" style="margin-top: 0.5rem;">Register</button>
            </form>
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9375rem;">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</body>
</html>
