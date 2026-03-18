<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Analytics\DashboardAnalyticsService;

class AnalyticsController extends Controller
{
    public function __invoke(DashboardAnalyticsService $analytics)
    {
        return view('admin.analytics.index', [
            'summary' => $analytics->adminSummary(),
        ]);
    }
}
