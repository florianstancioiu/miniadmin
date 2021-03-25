<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('storage/' . setting('site-logo')) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ setting('site-title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a class="image" href="{{ route('admin.users.edit', ['user' => auth()->id()]) }}">

                @if(auth()->user()->image)
                    <img src="{{ auth()->user()->image_url }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ url('storage/' . setting('site-user-logo')) }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </a>
            <div class="info">
                <a href="{{ route('admin.users.edit', ['user' => auth()->id()]) }}" class="d-block">{{ auth()->user()->full_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ __('partials.dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/pages')) active @endif">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            {{ __('partials.pages') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/posts'))) active @endif">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            {{ __('partials.posts') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/users'))) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ __('partials.users') }}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link @if(request()->routeIs('admin.settings.index')) active @endif">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ __('partials.settings') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
