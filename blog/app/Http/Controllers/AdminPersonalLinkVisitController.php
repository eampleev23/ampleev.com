<?php

namespace App\Http\Controllers;

use App\PersonalLinkVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPersonalLinkVisitController extends Controller
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
        $since = $period === 'all' ? null : now()->subDays((int) $period);

        $baseQuery = PersonalLinkVisit::query();
        if ($since) {
            $baseQuery->where('created_at', '>=', $since);
        }
        if (!$includeAdmin) {
            $baseQuery->where('is_admin', false);
        }

        $summaryRows = (clone $baseQuery)
            ->select(
                'source',
                DB::raw('COUNT(*) as visits_count'),
                DB::raw('COUNT(DISTINCT ip_hash) as unique_ips_count'),
                DB::raw('MAX(created_at) as last_visit_at')
            )
            ->groupBy('source')
            ->orderByDesc('visits_count')
            ->orderByDesc('last_visit_at')
            ->get();

        $visits = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->paginate(100)
            ->appends($request->query());

        return view('admin.personal_link_visits.index', [
            'period' => $period,
            'periods' => self::PERIODS,
            'includeAdmin' => $includeAdmin,
            'summaryRows' => $summaryRows,
            'visits' => $visits,
        ]);
    }
}
