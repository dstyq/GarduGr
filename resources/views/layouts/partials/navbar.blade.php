<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <img src="{{ asset('img/telkomsel-logo.png') }}" width="120px" class="image img" alt="User Image">
        </li>
    </ul>


    <ul class="navbar-nav ml-auto">
        <li class="dropdown user user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('img/users/'.(Auth::user()->avatar ?? 'user.png')) }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="{{ asset('img/users/'.(Auth::user()->avatar ?? 'user.png')) }}" class="img-circle" alt="User Image">
                    <p>
                        {{ Auth::user()->name }}
                        <small>{{ Auth::user()->getRoleNames()[0] }}</small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-left">
                        <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-default btn-flat" href="#" onclick="logout()">
                            {{ __('Logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>