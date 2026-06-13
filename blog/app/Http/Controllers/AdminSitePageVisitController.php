<?php

namespace App\Http\Controllers;

use App\SitePageVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSitePageVisitController extends Controller
{
    private const PERIODS = [
        '1' => '24 часа',
        '7' => '7 дней',
        '30' => '30 дней',
        '90' => '90 дней',
        'all' => 'Все время',
    ];

    public function index(Request $request)
    {
        $period = (string) $request->query('period', '7');
        if (!array_key_exists($period, self::PERIODS)) {
            $period = '7';
        }

        $includeAdmin = $request->boolean('include_admin');
        $includeOwner = $request->boolean('include_owner');
        $since = $period === 'all' ? null : now()->subDays((int) $period);

        $baseQuery = SitePageVisit::query();
        if ($since) {
            $baseQuery->where('created_at', '>=', $since);
        }
        if (!$includeAdmin) {
            $baseQuery->where('is_admin', false);
        }
        if (!$includeOwner) {
            $baseQuery->where('is_owner', false);
        }

        $totals = [
            'page_views' => (clone $baseQuery)->count(),
            'visitors' => (clone $baseQuery)->distinct('visitor_key')->count('visitor_key'),
            'sessions' => (clone $baseQuery)->distinct('session_key')->count('session_key'),
            'attributed' => (clone $baseQuery)->whereNotNull('attribution_source')->count(),
        ];

        $pageRows = (clone $baseQuery)
            ->select(
                'page_path',
                DB::raw('COUNT(*) as views_count'),
                DB::raw('COUNT(DISTINCT visitor_key) as visitors_count'),
                DB::raw('COUNT(DISTINCT session_key) as sessions_count'),
                DB::raw('MAX(created_at) as last_visit_at')
            )
            ->groupBy('page_path')
            ->orderByDesc('views_count')
            ->limit(50)
            ->get();

        $sourceRows = (clone $baseQuery)
            ->select(
                'attribution_source',
                'attribution_medium',
                DB::raw('COUNT(*) as views_count'),
                DB::raw('COUNT(DISTINCT visitor_key) as visitors_count'),
                DB::raw('MAX(created_at) as last_visit_at')
            )
            ->groupBy('attribution_source', 'attribution_medium')
            ->orderByDesc('views_count')
            ->limit(50)
            ->get();

        $deviceRows = (clone $baseQuery)
            ->select(
                'device_type',
                'platform_name',
                'browser_name',
                DB::raw('COUNT(*) as views_count'),
                DB::raw('COUNT(DISTINCT visitor_key) as visitors_count')
            )
            ->groupBy('device_type', 'platform_name', 'browser_name')
            ->orderByDesc('views_count')
            ->limit(50)
            ->get();

        $visits = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->paginate(100)
            ->appends($request->query());

        return view('admin.site_page_visits.index', [
            'period' => $period,
            'periods' => self::PERIODS,
            'includeAdmin' => $includeAdmin,
            'includeOwner' => $includeOwner,
            'totals' => $totals,
            'pageRows' => $pageRows,
            'sourceRows' => $sourceRows,
            'deviceRows' => $deviceRows,
            'visits' => $visits,
        ]);
    }
}
