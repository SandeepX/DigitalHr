<li class="nav-item {{ request()->routeIs('admin.projects.*')  ? 'active' : '' }}">
    <a
        href="{{ route('admin.projects.index') }}"
        data-href="{{ route('admin.projects.index') }}"
        class="nav-link">
        <i class="link-icon" data-feather="box"></i>
        <span class="link-title">Project Management</span>
    </a>
</li>
