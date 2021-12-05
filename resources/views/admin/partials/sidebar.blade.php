<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('storage/' . setting('site-logo')) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ setting('site-title') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a class="image" href="{{ route('admin.users.profile') }}">
                @if(auth()->user()->image)
                    <img src="{{ auth()->user()->image_url }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ url('storage/' . setting('site-user-logo')) }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </a>
            <div class="info">
                <a href="{{ route('admin.users.profile') }}" class="d-block">{{ auth()->user()->getFullName() }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('view dashboard')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('partials.dashboard') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view pages')
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/pages')) active @endif">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                {{ __('partials.pages') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view posts')
                    <li class="nav-item">
                        <a href="{{ route('admin.posts.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/posts'))) active @endif">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                {{ __('partials.posts') }}
                            </p>
                        </a>
                    </li>
                @endcan
                {{--
                @can('list-categories')
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/categories'))) active @endif">
                            <i class="nav-icon fas fa-clone"></i>
                            <p>
                                {{ __('partials.categories') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('list-tags')
                    <li class="nav-item">
                        <a href="{{ route('admin.tags.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/tags'))) active @endif">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>
                                {{ __('partials.tags') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('list-media')
                    <li class="nav-item">
                        <a href="{{ route('admin.media.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/media'))) active @endif">
                            <i class="nav-icon fas fa-file-image"></i>
                            <p>
                                {{ __('partials.media') }}
                            </p>
                        </a>
                    </li>
                @endcan
                --}}
                @can('view users')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/users'))) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('partials.users') }}
                            </p>
                        </a>
                    </li>
                @endcan
                {{--
                @can('view roles')
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/roles'))) active @endif">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>
                                {{ __('partials.roles') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view permissions')
                    <li class="nav-item">
                        <a href="{{ route('admin.permissions.index') }}" class="nav-link @if(Str::startsWith(request()->path(), 'admin/permissions'))) active @endif">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                {{ __('partials.permissions') }}
                            </p>
                        </a>
                    </li>
                @endcan
                --}}
                @can('view settings')
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link @if(request()->routeIs('admin.settings.index')) active @endif">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                {{ __('partials.settings') }}
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>
