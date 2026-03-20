<?php

namespace App\Services\Analytics;

use App\Models\CRM\Lead;
use App\Models\Support\SupportTicket;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Support\Facades\DB;

class DashboardAnalyticsService
{
    public function __construct(
        protected WhmcsService $whmcsService
    ) {
    }

    public function adminSummary(): array
    {
        return [
            'lead_count' => Lead::count(),
            'open_tickets' => SupportTicket::query()->whereIn('status', ['open', 'in_progress', 'waiting_client'])->count(),
            'lead_funnel' => Lead::query()
                ->select('stage', DB::raw('COUNT(*) as total'))
                ->groupBy('stage')
                ->pluck('total', 'stage')
                ->all(),
            'whmcs_sales' => $this->whmcsService->getSalesMetrics(),
        ];
    }
}
