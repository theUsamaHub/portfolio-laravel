<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
    <style>
        .auth-layout { display: flex; min-height: 100vh; }
        .auth-card { max-width: 400px; width: 100%; margin: auto; padding: 2rem; }
        .auth-logo { text-align: center; margin-bottom: 2rem; }
        .auth-logo h1 { font-family: var(--font-heading); font-size: 1.5rem; }
    </style>
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="/" style="text-decoration: none;"><h1>Portfolio CMS</h1></a>
                <p class="text-muted" style="margin-top: 0.5rem;">Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-between items-center mb-6">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9375rem;">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 0.875rem;">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary w-full">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
