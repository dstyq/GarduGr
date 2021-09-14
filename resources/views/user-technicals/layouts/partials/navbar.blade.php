<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="dropdown user user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('img/users/'.(Auth::guard('user-technical')->user()->avatar ?? 'user.png')) }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::guard('user-technical')->user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="{{ asset('img/users/'.(Auth::guard('user-technical')->user()->avatar ?? 'user.png')) }}" class="img-circle" alt="User Image">
                    <p>
                        {{ Auth::guard('user-technical')->user()->name }}
                        <small>User Technical</small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-right">
                        <a class="btn btn-default btn-flat" href="{{ route('user-technical.logout') }}">
                            {{ __('Logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>