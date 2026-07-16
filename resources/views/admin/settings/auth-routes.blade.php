@extends('layouts.admin')
@section('admin-content')
<div class="mb-6">
    <h2 style="font-size: 1.25rem; font-weight: 700;">Auth Routes</h2>
    <p class="text-muted" style="font-size:0.875rem;">Manage secret login, register, and password reset URLs. Change these anytime for security.</p>
</div>

<div class="grid grid-2 gap-6">
    <div class="card">
        <h3 style="font-weight: 600; margin-bottom: 1rem;">Current Routes</h3>
        <div class="grid gap-4">
            <div style="padding:0.75rem;background:var(--bg-secondary);border-radius:var(--radius);border:1px solid var(--border-color);">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                    <span class="badge badge-sm badge-success">Login</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);">Current URL</span>
                </div>
                <code style="font-size:0.9375rem;font-weight:600;color:var(--color-primary);">/{{ $routes['login'] }}</code>
                <p style="font-size:0.8125rem;color:var(--text-muted);margin-top:0.25rem;">Full URL: <span style="color:var(--text-primary);">{{ url('/' . $routes['login']) }}</span></p>
            </div>
            <div style="padding:0.75rem;background:var(--bg-secondary);border-radius:var(--radius);border:1px solid var(--border-color);">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                    <span class="badge badge-sm badge-info">Register</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);">Current URL</span>
                </div>
                <code style="font-size:0.9375rem;font-weight:600;color:var(--color-primary);">/{{ $routes['register'] }}</code>
                <p style="font-size:0.8125rem;color:var(--text-muted);margin-top:0.25rem;">Full URL: <span style="color:var(--text-primary);">{{ url('/' . $routes['register']) }}</span></p>
            </div>
            <div style="padding:0.75rem;background:var(--bg-secondary);border-radius:var(--radius);border:1px solid var(--border-color);">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                    <span class="badge badge-sm badge-warning">Forgot Password</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);">Current URL</span>
                </div>
                <code style="font-size:0.9375rem;font-weight:600;color:var(--color-primary);">/{{ $routes['forgot_password'] }}</code>
                <p style="font-size:0.8125rem;color:var(--text-muted);margin-top:0.25rem;">Full URL: <span style="color:var(--text-primary);">{{ url('/' . $routes['forgot_password']) }}</span></p>
            </div>
            <div style="padding:0.75rem;background:var(--bg-secondary);border-radius:var(--radius);border:1px solid var(--border-color);">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                    <span class="badge badge-sm badge-secondary">Reset Password</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);">Current URL</span>
                </div>
                <code style="font-size:0.9375rem;font-weight:600;color:var(--color-primary);">/{{ $routes['reset_password'] }}</code>
                <p style="font-size:0.8125rem;color:var(--text-muted);margin-top:0.25rem;">Full URL: <span style="color:var(--text-primary);">{{ url('/' . $routes['reset_password']) }}</span></p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="font-weight: 600; margin-bottom: 1rem;">Update Routes</h3>
        <form method="POST" action="{{ route('admin.auth-routes.update') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Login Path *</label>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="color:var(--text-muted);">/</span>
                    <input type="text" class="form-input @error('login_path') is-invalid @enderror" name="login_path" value="{{ old('login_path', $routes['login']) }}" required pattern="[a-zA-Z0-9_-]+" maxlength="50">
                </div>
                @error('login_path') <p class="form-error">{{ $message }}</p> @enderror
                <p class="form-help" style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">Letters, numbers, underscores, hyphens only. No spaces or special characters.</p>
            </div>
            <div class="form-group">
                <label class="form-label">Register Path *</label>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="color:var(--text-muted);">/</span>
                    <input type="text" class="form-input @error('register_path') is-invalid @enderror" name="register_path" value="{{ old('register_path', $routes['register']) }}" required pattern="[a-zA-Z0-9_-]+" maxlength="50">
                </div>
                @error('register_path') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Forgot Password Path *</label>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="color:var(--text-muted);">/</span>
                    <input type="text" class="form-input @error('forgot_password_path') is-invalid @enderror" name="forgot_password_path" value="{{ old('forgot_password_path', $routes['forgot_password']) }}" required pattern="[a-zA-Z0-9_-]+" maxlength="50">
                </div>
                @error('forgot_password_path') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Reset Password Path *</label>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="color:var(--text-muted);">/</span>
                    <input type="text" class="form-input @error('reset_password_path') is-invalid @enderror" name="reset_password_path" value="{{ old('reset_password_path', $routes['reset_password']) }}" required pattern="[a-zA-Z0-9_-]+" maxlength="50">
                </div>
                @error('reset_password_path') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="padding:0.75rem;background:var(--color-warning-light);border-radius:var(--radius);margin-bottom:1rem;">
                <p style="font-size:0.8125rem;color:var(--color-warning);font-weight:500;">Warning: Changing these routes will invalidate any existing password reset links. All routes must be unique.</p>
            </div>

            <button type="submit" class="btn btn-primary">Update Auth Routes</button>
        </form>
    </div>
</div>

<div class="card mt-6">
    <h3 style="font-weight: 600; margin-bottom: 1rem;">Quick Actions</h3>
    <div class="flex flex-wrap gap-2">
        <a href="{{ url('/' . $routes['login']) }}" class="btn btn-outline btn-sm" target="_blank">Test Login Page</a>
        <a href="{{ url('/' . $routes['register']) }}" class="btn btn-outline btn-sm" target="_blank">Test Register Page</a>
        <a href="{{ url('/' . $routes['forgot_password']) }}" class="btn btn-outline btn-sm" target="_blank">Test Forgot Password</a>
    </div>
</div>
@endsection
