@extends('layouts.admin')
@section('admin-content')
<div class="mb-6"><h2 style="font-size: 1.25rem; font-weight: 700;">Contact Settings</h2></div>
<form method="POST" action="{{ route('admin.contact-settings.update') }}">
    @csrf
    <div class="card">
        <div class="grid grid-2 gap-4">
            <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input" name="email" value="{{ $settings->email ?? '' }}"></div>
            <div class="form-group"><label class="form-label">Phone</label><input type="text" class="form-input" name="phone" value="{{ $settings->phone ?? '' }}"></div>
            <div class="form-group"><label class="form-label">WhatsApp</label><input type="text" class="form-input" name="whatsapp" value="{{ $settings->whatsapp ?? '' }}"></div>
            <div class="form-group"><label class="form-label">Country</label><input type="text" class="form-input" name="country" value="{{ $settings->country ?? '' }}"></div>
            <div class="form-group"><label class="form-label">State</label><input type="text" class="form-input" name="state" value="{{ $settings->state ?? '' }}"></div>
            <div class="form-group"><label class="form-label">City</label><input type="text" class="form-input" name="city" value="{{ $settings->city ?? '' }}"></div>
            <div class="form-group"><label class="form-label">Postal Code</label><input type="text" class="form-input" name="postal_code" value="{{ $settings->postal_code ?? '' }}"></div>
        </div>
        <div class="form-group"><label class="form-label">Address</label><textarea class="form-textarea" name="address" rows="2">{{ $settings->address ?? '' }}</textarea></div>
        <div class="form-group"><label class="form-label">Working Hours (one per line)</label><textarea class="form-textarea" name="working_hours" rows="3" placeholder="Monday - Friday: 9am - 6pm&#10;Saturday: 10am - 2pm">{{ is_array($settings->working_hours ?? null) ? implode("\n", $settings->working_hours) : '' }}</textarea></div>
        <div class="form-group"><label class="form-label">Google Maps Embed URL</label><input type="text" class="form-input" name="map_embed_url" value="{{ $settings->map_embed_url ?? '' }}" placeholder="https://www.google.com/maps/embed?..."></div>
        <button type="submit" class="btn btn-primary">Save Contact Settings</button>
    </div>
</form>
@endsection
