<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: rgb(255,15,15) !important;
background: linear-gradient(333deg, rgba(255,15,15,1) 35%, rgba(255,166,0,1) 100%) !important;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        {{-- <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-bold" style="color: white !important;">Hyper Access</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/users/'.(Auth::guard('web')->user()->avatar ?? 'user.png')) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            
            <div class="info">
                <a href="#" class="d-block" style="color: white !important;">{{ Auth::guard('web')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(auth()->user()->can('dashbord-overview') || auth()->user()->can('dashbord-maps'))
                <li class="nav-item {{ (request()->segment(1) == 'overview' || request()->segment(1) == 'maps') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ (request()->segment(1) == 'overview' || request()->segment(1) == 'maps') ? 'active' : ''}}">
                      <i class="nav-icon fas fa-tachometer-alt"></i>

                      <p style="color: white !important;">
                        Dashboard <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @if(auth()->user()->can('dashbord-overview'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.overview') }}" class="nav-link {{ (request()->segment(1) == 'overview' ) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>

                                <p style="color: white !important;">Overview</p>
                            </a>
                        </li>
                        @endif

                        @if(auth()->user()->can('dashbord-maps'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.maps') }}" class="nav-link {{ (request()->segment(1) == 'maps' ) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>

                                <p style="color: white !important;">Maps</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(auth()->user()->can('asset-list'))
                <li class="nav-item">
                    <a href="{{ route('assets.index') }}" class="nav-link {{ (request()->segment(1) == 'assets' ) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-archive"></i>

                        <p>Assets</p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('cctv-list'))
                <li class="nav-item">
                    <a href="{{ route('device.index') }}" class="nav-link {{ (request()->segment(1) == 'device' ) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-video"></i>

                        <p style="color: white !important;">Device Management</p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('history-log-list'))
                <li class="nav-item">
                    <a href="{{ route('history-log.index') }}" class="nav-link {{ (request()->segment(1) == 'history-log' ) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-history"></i>

                        <p style="color: white !important;">History</p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('maintenance-list') || auth()->user()->can('work-order-list'))
                <li class="nav-item {{ (request()->segment(1) == 'work-orders' || request()->segment(1) == 'schedule-maintenances') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ (request()->segment(1) == 'work-orders' || request()->segment(1) == 'schedule-maintenances') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tools"></i>

                        <p style="color: white !important;">
                            Maintenances <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->can('maintenance-list'))
                        <li class="nav-item">
                            <a href="{{ route('schedule-maintenances.index') }}" class="nav-link {{ (request()->segment(1) == 'schedule-maintenances' ) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>

                                <p style="color: white !important;">Schedule</p>
                            </a>
                        </li>
                        @endif

                        @if(auth()->user()->can('work-order-list'))
                        <li class="nav-item">
                            <a href="{{ route('work-orders.index') }}" class="nav-link {{ (request()->segment(1) == 'work-orders' ) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                
                                <p style="color: white !important;">Work Order</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(auth()->user()->can('location-list'))
                <li class="nav-item">
                  <a href="{{ route('locations.index') }}" class="nav-link {{ (request()->segment(1) == 'locations') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p style="color: white !important;"> Location</p>
                  </a>
                </li>
                @endif

                @if(auth()->user()->can('master-data'))
                <li class="nav-item">
                  <a href="{{ route('master-data.index') }}" class="nav-link {{ (request()->segment(1) == 'master-data' || request()->segment(1) == 'departements' || request()->segment(1) == 'users' || request()->segment(1) == 'user-technicals' || request()->segment(1) == 'user-technical-groups' || request()->segment(1) == 'categories' || request()->segment(1) == 'types' || request()->segment(1) == 'materials' || request()->segment(1) == 'boms' || request()->segment(1) == 'tasks' || request()->segment(1) == 'task-groups') ? 'active' : ''}}">
                      <i class="nav-icon fas fa-folder"></i>
                      <p style="color: white !important;">Master Data</p>
                  </a>
                </li>
                @endif

                @if (auth()->user()->can('report-maintenance'))
                <li class="nav-item">
                    <a href="{{ route('reports') }}" class="nav-link {{ (request()->segment(1) == 'reports') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p style="color: white !important;">Report Maintenance</p>
                    </a>
                  </li>
                @endif

                <li class="nav-item">
                    <a href="#" onclick="logout()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p style="color: white !important;">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>