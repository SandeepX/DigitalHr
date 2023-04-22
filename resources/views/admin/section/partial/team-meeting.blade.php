
<li class="nav-item {{ request()->routeIs('admin.team-meetings.*')  ? 'active' : '' }}">
    @can('list_team_meeting')
        <a
            href="{{ route('admin.team-meetings.index') }}"
            data-href="{{ route('admin.team-meetings.index') }}"
            class="nav-link">
            <i class="link-icon" data-feather="globe"></i>
            <span class="link-title">Team Meeting</span>
        </a>
    @endcan
</li>
