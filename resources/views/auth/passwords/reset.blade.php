<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
    <title>Reset Password - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo"><a href="/"><h1>Portfolio CMS</h1></a><p class="text-muted" style="margin-top: 0.5rem;">Set your new password</p></div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input" name="email" value="{{ old('email', $email) }}" required></div>
                <div class="form-group"><label class="form-label">Password</label><input type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="form-label">Confirm Password</label><input type="password" class="form-input" name="password_confirmation" required></div>
                <button type="submit" class="btn btn-primary w-full">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
