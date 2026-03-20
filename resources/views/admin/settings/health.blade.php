@extends('layouts.dashboard', [
    'title' => 'System Health',
    'heading' => 'System Health',
    'subheading' => 'Cron, queue, and outbound email health for cPanel-style deployments.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'Clients', 'route' => 'admin.clients.index', 'active' => 'admin.clients.*'],
        ['label' => 'Store', 'route' => 'admin.store.products.index', 'active' => 'admin.store.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    <div class="dashboard-subnav">
        <a href="{{ route('admin.settings.index') }}" class="dashboard-subnav-link">Settings</a>
        <a href="{{ route('admin.settings.health') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Health</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card">
            <div class="metric-label">Scheduler</div>
            <div class="metric-value">{{ $schedulerHealthy ? 'Healthy' : 'Stale' }}</div>
            <div class="mt-2 text-sm text-slate-500">{{ $schedulerLastRanAt?->diffForHumans() ?? 'Never recorded' }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Queue Worker</div>
            <div class="metric-value">{{ $queueHealthy ? 'Healthy' : 'Stale' }}</div>
            <div class="mt-2 text-sm text-slate-500">{{ $queueLastFinishedAt?->diffForHumans() ?? 'Never recorded' }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Queued Jobs</div>
            <div class="metric-value">{{ $jobsPending }}</div>
            <div class="mt-2 text-sm text-slate-500">Reserved: {{ $jobsReserved }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Failed Jobs</div>
            <div class="metric-value">{{ $failedJobs }}</div>
            <div class="mt-2 text-sm text-slate-500">Failed emails: {{ $failedEmails }}</div>
        </div>
    </div>

    <div class="section-grid mt-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="card">
            <div class="panel-title">Cron Command for cPanel</div>
            <div class="panel-subtitle">Use one cron entry. It will trigger the scheduler, the HR digest, and queue processing.</div>

            <div
                class="mt-6 rounded-[24px] border border-slate-200 bg-slate-950 px-5 py-4 text-sm text-slate-100"
                x-data="{ copied: false }"
            >
                <code class="block break-all leading-7">{{ $cronCommand }}</code>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button
                        type="button"
                        class="btn-primary"
                        @click="navigator.clipboard.writeText(@js($cronCommand)).then(() => { copied = true; setTimeout(() => copied = false, 1800); })"
                    >
                        Copy Cron Command
                    </button>
                    <span class="text-sm text-slate-300" x-show="copied" x-cloak>Copied.</span>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="info-pair">
                    <div class="info-label">Last scheduler heartbeat</div>
                    <div class="info-value">{{ $schedulerLastRanAt?->format('d M Y, h:i:s A') ?? 'Not recorded yet' }}</div>
                </div>
                <div class="info-pair">
                    <div class="info-label">Last queue run started</div>
                    <div class="info-value">{{ $queueLastStartedAt?->format('d M Y, h:i:s A') ?? 'Not recorded yet' }}</div>
                </div>
                <div class="info-pair">
                    <div class="info-label">Last queue run finished</div>
                    <div class="info-value">{{ $queueLastFinishedAt?->format('d M Y, h:i:s A') ?? 'Not recorded yet' }}</div>
                </div>
                <div class="info-pair">
                    <div class="info-label">Queued emails</div>
                    <div class="info-value">{{ $queuedEmails }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="panel-title">Health Interpretation</div>
            <div class="panel-subtitle">Simple operational guidance based on the last scheduler heartbeat.</div>

            <div class="dashboard-list mt-6">
                <div class="dashboard-item block">
                    <div class="font-semibold text-slate-800">Cron status</div>
                    <div class="mt-2 text-sm text-slate-600">
                        @if ($schedulerHealthy)
                            Cron looks healthy. The Laravel scheduler has run within the last 3 minutes.
                        @else
                            Cron looks stale. The scheduler heartbeat is older than 3 minutes or missing.
                        @endif
                    </div>
                </div>
                <div class="dashboard-item block">
                    <div class="font-semibold text-slate-800">Queue status</div>
                    <div class="mt-2 text-sm text-slate-600">
                        @if ($queueHealthy)
                            Queue processing looks healthy. The scheduler-driven queue worker has finished recently.
                        @else
                            Queue processing looks stale. Check cron first, then inspect queued and failed jobs.
                        @endif
                    </div>
                </div>
                <div class="dashboard-item block">
                    <div class="font-semibold text-slate-800">Recommended checks</div>
                    <div class="mt-2 text-sm text-slate-600">
                        1. Add the cron command in cPanel.
                        <br>2. Wait 2-3 minutes and refresh this page.
                        <br>3. If stale, run <code>php artisan schedule:run</code> once manually and recheck.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
