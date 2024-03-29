<nav class="main-header navbar navbar-expand navbar-dark navbar-notice">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a target="_blank" href="{{ url('/') }}" class="nav-link">{{ __('partials.home') }}</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger" type="submit">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('partials.logout') }}
                </button>
            </form>
        </li>
    </ul>
</nav>
