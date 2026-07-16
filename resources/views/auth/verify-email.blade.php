<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
    <title>Verify Email - {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}</title>
    @vite(['resources/css/app.scss'])
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo"><a href="/"><h1>Portfolio CMS</h1></a></div>
            <p style="text-align: center; margin-bottom: 1.5rem;">Please verify your email address by clicking the link in the email we sent you.</p>
            @if (session('status'))
                <div style="padding: 0.75rem; background: var(--color-success-light); color: var(--color-success); border-radius: var(--radius); margin-bottom: 1rem; text-align: center;">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary w-full">Resend Verification Email</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" style="text-align: center; margin-top: 1rem;">@csrf<button type="submit" style="font-size: 0.9375rem;">Logout</button></form>
        </div>
    </div>
</body>
</html>
