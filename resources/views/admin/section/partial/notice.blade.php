<li class="nav-item {{ request()->routeIs('admin.notices.*')  ? 'active' : '' }}">
    @can('list_notice')
        <a
            href="{{ route('admin.notices.index') }}"
            data-href="{{ route('admin.notices.index') }}"
            class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Notice</span>
        </a>
    @endcan
</li>
