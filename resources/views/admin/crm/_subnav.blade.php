<div class="dashboard-subnav">
    <a href="{{ route('admin.crm.index') }}" class="dashboard-subnav-link {{ request()->routeIs('admin.crm.index') ? 'dashboard-subnav-link-active' : '' }}">Overview</a>
    <a href="{{ route('admin.crm.leads.index') }}" class="dashboard-subnav-link {{ request()->routeIs('admin.crm.leads.*') ? 'dashboard-subnav-link-active' : '' }}">Leads</a>
    <a href="{{ route('admin.crm.contacts.index') }}" class="dashboard-subnav-link {{ request()->routeIs('admin.crm.contacts.*') ? 'dashboard-subnav-link-active' : '' }}">Contacts</a>
    <a href="{{ route('admin.crm.follow-ups.index') }}" class="dashboard-subnav-link {{ request()->routeIs('admin.crm.follow-ups.*') ? 'dashboard-subnav-link-active' : '' }}">Follow-Ups</a>
</div>
