@extends('layouts.dashboard', [
    'title' => 'Security',
    'heading' => 'Security',
    'subheading' => 'Two-factor access, session management, and account protection.',
    'nav' => [
        ['label' => 'Overview', 'route' => auth()->user()->hasRole('client') ? 'client.dashboard' : (auth()->user()->hasAnyRole(['hr', 'sales', 'support']) ? 'employee.dashboard' : 'admin.dashboard'), 'active' => auth()->user()->hasRole('client') ? 'client.dashboard' : (auth()->user()->hasAnyRole(['hr', 'sales', 'support']) ? 'employee.dashboard' : 'admin.dashboard')],
        ['label' => 'Profile', 'route' => auth()->user()->hasRole('client') ? 'client.profile.edit' : (auth()->user()->hasAnyRole(['hr', 'sales', 'support']) ? 'employee.profile.index' : 'admin.settings.index'), 'active' => auth()->user()->hasRole('client') ? 'client.profile.*' : (auth()->user()->hasAnyRole(['hr', 'sales', 'support']) ? 'employee.profile.*' : 'admin.settings.*')],
        ['label' => 'Security', 'route' => 'security.index', 'active' => 'security.*'],
    ],
])

@section('content')
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[0.92fr_1.08fr]">
        <div class="card">
            <div class="panel-title">Two-Factor Authentication</div>
            <div class="panel-subtitle">Email-based verification for every login after password authentication.</div>

            <form method="POST" action="{{ route('security.two-factor.update') }}" class="mt-6 space-y-4">
                @csrf
                @method('PATCH')
                <label class="dashboard-item cursor-pointer">
                    <div>
                        <div class="font-semibold text-slate-800">Enable email verification on sign-in</div>
                        <div class="mt-1 text-slate-500">When enabled, a 6-digit code is sent to your account email after password login.</div>
                    </div>
                    <input type="checkbox" name="two_factor_enabled" value="1" class="h-5 w-5 rounded border-slate-300 text-brand-green focus:ring-brand-green" @checked($user->two_factor_enabled)>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Current password</span>
                    <input class="input mt-2" type="password" name="current_password" required>
                </label>
                <button class="btn-primary">Save Security Settings</button>
            </form>
        </div>

        <div class="card overflow-x-auto">
            <div class="panel-title">Active Sessions</div>
            <div class="panel-subtitle">Review where your account is signed in and revoke sessions you do not trust.</div>
            <table class="dashboard-table mt-6">
                <thead>
                    <tr><th>IP</th><th>Last Activity</th><th>Browser</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                        <tr>
                            <td>{{ $session->ip_address ?: 'Unknown' }} @if($session->is_current)<span class="status-badge ml-2">Current</span>@endif</td>
                            <td>{{ $session->last_activity->format('d M Y, h:i A') }}</td>
                            <td class="max-w-[320px] truncate">{{ $session->user_agent ?: 'Unknown browser' }}</td>
                            <td class="text-right">
                                @unless($session->is_current)
                                    <form method="POST" action="{{ route('security.sessions.destroy', $session->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-dark px-4 py-2 text-xs">Revoke</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form method="POST" action="{{ route('security.sessions.destroy-others') }}" class="mt-6 flex flex-col gap-4 rounded-[24px] border border-slate-200 bg-slate-50 p-5 md:flex-row md:items-end">
                @csrf
                @method('DELETE')
                <label class="block flex-1">
                    <span class="text-sm font-medium text-slate-700">Current password</span>
                    <input class="input mt-2" type="password" name="current_password" required>
                </label>
                <button class="btn-primary">Sign Out Other Sessions</button>
            </form>
        </div>
    </div>
@endsection
