<li class="nav-item {{ request()->routeIs('admin.clients.*')  ? 'active' : '' }}">
    @can('view_client_list')
        <a
            href="{{ route('admin.clients.index') }}"
            data-href="{{ route('admin.clients.index') }}"
            class="nav-link">
            <i class="link-icon" data-feather="heart"></i>
            <span class="link-title">Clients</span>
        </a>
    @endcan
</li>
