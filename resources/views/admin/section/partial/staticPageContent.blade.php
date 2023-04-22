<li class="nav-item">
    @can('list_content')
        <a href="{{ route('admin.static-page-contents.index') }}"
           data-href="{{ route('admin.static-page-contents.index') }}" class="nav-link">
            <i class="link-icon" data-feather="airplay"></i>
            <span class="link-title">Content Management</span>
        </a>
    @endcan
</li>
