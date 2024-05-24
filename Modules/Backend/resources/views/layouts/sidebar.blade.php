<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#{{ route('admin.plugins.index') }}"
                aria-expanded="false" aria-controls="{{ route('admin.plugins.index') }}">
                <span class="menu-title">Plugins</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="{{ route('admin.plugins.index') }}">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.plugins.index') }}">Buttons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.plugins.index') }}">Dropdowns</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.menu') }}">
                <span class="menu-title">Menu</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.add-page') }}">
                <span class="menu-title">Add Page</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
