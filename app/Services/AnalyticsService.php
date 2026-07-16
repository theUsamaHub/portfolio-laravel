<?php

namespace App\Services;

use App\Models\PageView;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', 300, function () {
            return [
                'total_page_views' => PageView::count(),
                'today_views' => PageView::today()->count(),
                'monthly_views' => PageView::where('created_at', '>=', now()->startOfMonth())->count(),
                'unique_visitors' => PageView::distinct('ip_address')->count(),
                'popular_pages' => PageView::selectRaw('path, count(*) as views')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('path')
                    ->orderByDesc('views')
                    ->limit(10)
                    ->get(),
                'views_last_30_days' => PageView::where('created_at', '>=', now()->subDays(30))
                    ->selectRaw("date(created_at) as date, count(*) as views")
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get(),
            ];
        });
    }

    public function getRecentActivity(int $limit = 10): array
    {
        return \App\Models\ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
