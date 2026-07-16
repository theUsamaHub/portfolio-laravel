@extends('layouts.admin')

@section('admin-content')
<div class="mb-6">
    <h2 style="font-size: 1.5rem; font-weight: 700;">Welcome back, {{ auth()->user()->name }}</h2>
    <p style="color: var(--text-muted);">Here's what's happening with your portfolio.</p>
</div>

{{-- Primary Stats Row --}}
<div class="grid grid-4 mb-6">
    <div class="stat-card" data-aos="fade-up">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Total Projects</div>
        </div>
        <div class="stat-card-value">{{ $projectCount }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">{{ $publishedProjects }} published / {{ $draftProjects }} drafts</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-secondary-light);display:flex;align-items:center;justify-content:center;color:var(--color-secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Blog Posts</div>
        </div>
        <div class="stat-card-value">{{ $postCount }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">{{ $publishedPosts }} published / {{ $draftPosts }} drafts</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-success-light);display:flex;align-items:center;justify-content:center;color:var(--color-success);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Total Messages</div>
        </div>
        <div class="stat-card-value">{{ $totalMessages }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">{{ $todayMessages }} today / {{ $repliedMessages }} replied</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:{{ $unreadMessages > 0 ? 'var(--color-danger-light)' : 'var(--color-success-light)' }};display:flex;align-items:center;justify-content:center;color:{{ $unreadMessages > 0 ? 'var(--color-danger)' : 'var(--color-success)' }};">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Unread Messages</div>
        </div>
        <div class="stat-card-value" style="color:{{ $unreadMessages > 0 ? 'var(--color-danger)' : 'var(--color-success)' }};">{{ $unreadMessages }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.25rem;">{{ $unreadMessages > 0 ? 'Needs attention' : 'All caught up!' }}</div>
    </div>
</div>

{{-- Analytics Row --}}
<div class="grid grid-3 mb-6">
    <div class="stat-card" data-aos="fade-up">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-info-light);display:flex;align-items:center;justify-content:center;color:var(--color-info);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Page Views Today</div>
        </div>
        <div class="stat-card-value">{{ number_format($todayViews) }}</div>
    </div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-accent-light, #E0F2FE);display:flex;align-items:center;justify-content:center;color:var(--color-accent);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Views This Month</div>
        </div>
        <div class="stat-card-value">{{ number_format($monthViews) }}</div>
    </div>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius);background:var(--color-warning-light);display:flex;align-items:center;justify-content:center;color:var(--color-warning);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div class="stat-card-label" style="margin:0;">Total Views</div>
        </div>
        <div class="stat-card-value">{{ number_format($totalViews) }}</div>
    </div>
</div>

{{-- Content Sections Stats --}}
<div class="grid grid-4 mb-6">
    <div class="card" data-aos="fade-up">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Skills</span>
            <a href="{{ route('admin.skills.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $skillCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="50">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Services</span>
            <a href="{{ route('admin.services.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $serviceCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="100">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Testimonials</span>
            <a href="{{ route('admin.testimonials.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $testimonialCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="150">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Experiences</span>
            <a href="{{ route('admin.experiences.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $experienceCount }}</div>
    </div>
</div>

<div class="grid grid-4 mb-6">
    <div class="card" data-aos="fade-up">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Education</span>
            <a href="{{ route('admin.educations.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $educationCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="50">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Certificates</span>
            <a href="{{ route('admin.certificates.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $certificateCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="100">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Awards</span>
            <a href="{{ route('admin.awards.index') }}" style="font-size:0.75rem;color:var(--color-primary);">Manage</a>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $awardCount }}</div>
    </div>
    <div class="card" data-aos="fade-up" data-aos-delay="150">
        <div class="flex justify-between items-center mb-2">
            <span style="font-size:0.8125rem;color:var(--text-muted);">Subscribers</span>
            <span style="font-size:0.75rem;color:var(--color-success);">Active</span>
        </div>
        <div style="font-size:1.5rem;font-weight:700;">{{ $subscriberCount }}</div>
    </div>
</div>

{{-- Weekly Views Chart (simple bar chart) --}}
<div class="card mb-6" data-aos="fade-up">
    <div class="card-header">
        <h3 style="font-size: 1rem; font-weight: 600;">Page Views - Last 7 Days</h3>
    </div>
    <div class="card-body">
        @php
            $viewMap = [];
            foreach($weeklyViews as $v) { $viewMap[$v->date] = $v->views; }
            $chartDays = [];
            for($i = 6; $i >= 0; $i--) {
                $d = now()->subDays($i)->format('Y-m-d');
                $chartDays[] = ['date' => $d, 'views' => $viewMap[$d] ?? 0];
            }
            $maxViews = max(array_column($chartDays, 'views'));
            if($maxViews == 0) $maxViews = 1;
            $maxBarHeight = 100;
        @endphp
        <div style="display:flex;align-items:flex-end;gap:0.75rem;height:160px;padding:1.5rem 0.5rem 0.5rem;">
            @foreach($chartDays as $day)
                @php $barHeight = max(4, round(($day['views'] / $maxViews) * $maxBarHeight)); @endphp
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;height:100%;gap:0.375rem;">
                    <span style="font-size:0.75rem;font-weight:600;color:var(--text-primary);">{{ $day['views'] }}</span>
                    <div style="width:100%;height:{{ $barHeight }}px;background:linear-gradient(to top, var(--color-primary), var(--color-accent));border-radius:var(--radius-sm) var(--radius-sm) 0 0;min-height:4px;"></div>
                    <span style="font-size:0.6875rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($day['date'])->format('D') }}</span>
                    <span style="font-size:0.625rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($day['date'])->format('M d') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent Content & Messages --}}
<div class="grid grid-2 gap-6 mb-6">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 style="font-size: 1rem; font-weight: 600;">Recent Messages</h3>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="card-body">
            @forelse($recentMessages as $message)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <div class="flex justify-between items-center">
                        <strong style="font-size: 0.9375rem;">{{ $message->name }}</strong>
                        <span class="badge badge-sm {{ $message->status === 'unread' ? 'badge-danger' : 'badge-success' }}">{{ $message->status }}</span>
                    </div>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0;">{{ Str::limit($message->subject, 50) }}</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0;">{{ $message->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="empty-state"><p class="empty-state-title">No messages yet</p></div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 style="font-size: 1rem; font-weight: 600;">Recent Projects</h3>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="card-body">
            @forelse($recentProjects as $project)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <div class="flex justify-between items-center">
                        <strong style="font-size: 0.9375rem;">{{ $project->name }}</strong>
                        <span class="badge badge-sm {{ $project->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ $project->status }}</span>
                    </div>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0;">{{ $project->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="empty-state"><p class="empty-state-title">No projects yet</p></div>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-2 gap-6 mb-6">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 style="font-size: 1rem; font-weight: 600;">Recent Blog Posts</h3>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="card-body">
            @forelse($recentPosts as $post)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <div class="flex justify-between items-center">
                        <strong style="font-size: 0.9375rem;">{{ $post->name }}</strong>
                        <span class="badge badge-sm {{ $post->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ $post->status }}</span>
                    </div>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0;">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="empty-state"><p class="empty-state-title">No posts yet</p></div>
            @endforelse
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1rem; font-weight: 600;">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Project
                </a>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Blog Post
                </a>
                <a href="{{ route('admin.hero.edit') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Edit Hero
                </a>
                <a href="{{ route('admin.about.edit') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Edit About
                </a>
                <a href="{{ route('admin.skills.index') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    Manage Skills
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33"/></svg>
                    Site Settings
                </a>
                <a href="{{ route('admin.seo.index') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    SEO Settings
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline" target="_blank" style="justify-content:flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    View Site
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Activity Log --}}
@if($activityLogs->count())
<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h3 style="font-size: 1rem; font-weight: 600;">Activity Log</h3>
    </div>
    <div class="card-body">
        @foreach($activityLogs as $log)
            <div style="padding: 0.5rem 0; border-bottom: 1px solid var(--border-color); font-size: 0.875rem;">
                <span class="font-semibold">{{ $log->user?->name ?? 'System' }}</span>
                <span class="text-muted">{{ $log->action }}</span>
                @if($log->description)
                    <span class="text-muted">- {{ $log->description }}</span>
                @endif
                <span class="text-muted" style="float: right;">{{ $log->created_at?->diffForHumans() }}</span>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
