<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Analytics\DashboardAnalyticsService;

class DashboardController extends Controller
{
    public function __invoke(DashboardAnalyticsService $analytics)
    {
        return view('admin.dashboard.index', [
            'summary' => $analytics->adminSummary(),
        ]);
    }
}
