<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio CMS') }}</title>
    @vite(['resources/css/app.scss'])
    <style>
        .welcome-layout {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
        }
        .welcome-layout h1 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .welcome-layout p {
            color: var(--text-muted);
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }
        .welcome-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="welcome-layout">
        <h1>{{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio CMS') }}</h1>
        <p>{{ \App\Helpers\SettingHelper::get('site_tagline', 'Content Management System') }}</p>
        <div class="welcome-actions">
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-primary">Admin Login</a>
            @endif
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
            @endif
        </div>
    </div>
</body>
</html>
