<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        {{-- <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="30"> --}}
                    </span>
                    <span class="logo-lg text-center">
                        {{-- <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="30"> --}}
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        {{-- <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="30"> --}}
                    </span>
                    
                    <span class="logo-lg text-center">
                        {{-- <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="30"> --}}
                    </span>
                </a>
            </div>

            {{-- <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button> --}}
        </div>

        <div class="d-flex">
            <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="30">
            {{-- <h4>DAHSBOARD MONITORING</h4> --}}
        </div>
        
        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill countAccessDoor" id="">{{ $history_notifications->count() }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                {{-- <a href="#!" class="small text-reset text-decoration-underline"> Unread (3)</a> --}}
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @foreach ($history_notifications as $notif)
                        <a href="{{ route('notification-log.index').'?id='.$notif->id }}"class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('assets/images/users/avatar-3.jpg') }}" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ ucwords(str_replace('_',' ', $notif->type)) }} {!! $notif->getStatus() !!}</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">{{ $notif->getLocation()->name ?? $notif->location }}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>{{ $notif->datetime }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('notification-log.index') }}?id=all">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span> 
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('img/users/'.(Auth::user()->avatar ?? 'user.png')) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" onclick="logout()"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>