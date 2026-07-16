<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Service;
use App\Models\Certificate;
use App\Models\Award;
use App\Models\PageView;
use App\Models\SocialLink;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // Content stats
            'projectCount' => Project::count(),
            'publishedProjects' => Project::where('status', 'published')->count(),
            'draftProjects' => Project::where('status', 'draft')->count(),
            'postCount' => Post::count(),
            'publishedPosts' => Post::where('status', 'published')->count(),
            'draftPosts' => Post::where('status', 'draft')->count(),

            // Message stats
            'totalMessages' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::unread()->count(),
            'repliedMessages' => ContactMessage::replied()->count(),
            'todayMessages' => ContactMessage::whereDate('created_at', today())->count(),

            // Content sections stats
            'skillCount' => Skill::count(),
            'testimonialCount' => Testimonial::count(),
            'experienceCount' => Experience::count(),
            'educationCount' => Education::count(),
            'serviceCount' => Service::count(),
            'certificateCount' => Certificate::count(),
            'awardCount' => Award::count(),
            'socialLinkCount' => SocialLink::count(),

            // Analytics
            'todayViews' => PageView::today()->count(),
            'monthViews' => PageView::where('created_at', '>=', now()->startOfMonth())->count(),
            'totalViews' => PageView::count(),
            'subscriberCount' => NewsletterSubscriber::active()->count(),

            // Recent data
            'recentMessages' => ContactMessage::latest()->limit(5)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
            'recentPosts' => Post::latest()->limit(5)->get(),
            'activityLogs' => ActivityLog::with('user')->latest()->limit(10)->get(),

            // Charts - views last 7 days
            'weeklyViews' => PageView::where('created_at', '>=', now()->subDays(7))
                ->selectRaw("date(created_at) as date, count(*) as views")
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ]);
    }
}
