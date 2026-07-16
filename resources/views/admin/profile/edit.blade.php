@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Profile Settings</h2></div>

<div class="grid grid-2 gap-6">
    {{-- Profile Info --}}
    <div class="card">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Profile Information</h3>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" class="form-input" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea class="form-textarea" name="bio" rows="4">{{ old('bio', $user->bio ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <div>
        {{-- Password --}}
        <div class="card mb-6">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Update Password</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-input @error('current_password') is-invalid @enderror" name="current_password" required>
                    @error('current_password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" class="form-input" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="card" style="border-color: var(--color-danger);">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-danger);">Delete Account</h3>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Permanently delete your account and all associated data.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
                @csrf @method('DELETE')
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-input" name="password" required placeholder="Enter your password to confirm">
                </div>
                <button type="submit" class="btn btn-danger w-full">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection
