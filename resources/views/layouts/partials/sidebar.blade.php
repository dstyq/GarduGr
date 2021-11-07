<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu" style="background-color: rgb(27, 27, 27);">
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if(auth()->user()->can('dashbord-maps-access-door') || auth()->user()->can('dashbord-maps-cctv'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard Maps</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @if(auth()->user()->can('dashbord-maps-cctv'))
                        <li><a href="{{ route('dashboard.maps-cctv') }}">CCTV</a></li>
                        @endif

                        @if(auth()->user()->can('dashbord-maps-access-door'))
                        <li><a href="webrun:C:\Program Files (x86)\Rosslare\AxTraxNG Client\Client.exe">Access Door</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(auth()->user()->can('cctv-list') || auth()->user()->can('access-door-list'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="trello"></i>
                        <span data-key="t-contacts">Device Management</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        @if(auth()->user()->can('cctv-list'))
                        <li><a href="{{ route('cctv.index') }}">CCTV</a></li>
                        @endif

                        {{-- @if(auth()->user()->can('access-door-list'))
                        <li><a href="{{ route('access-door.index') }}">Access Door</a></li>
                        @endif --}}
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->can('location-list'))
                <li>
                    <a href="{{ route('locations.index') }}">
                        <i class="mdi mdi-map-marker-radius"></i>
                        <span data-key="t-dashboard">Location</span>
                    </a>
                </li>
                @endif
                
                @if(auth()->user()->can('notification-log-list'))
                <li>
                    <a href="{{ route('notification-log.index') }}">
                        <i class="mdi mdi-bell-outline"></i>
                        <span data-key="t-dashboard">Notification Log</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('history-log-list'))
                <li>
                    <a href="{{ route('history-log.index') }}">
                        <i class="mdi mdi-history"></i>
                        <span data-key="t-dashboard">History</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('master-data'))
                <li>
                    <a href="{{ route('master-data.index') }}">
                        <i class="mdi mdi-folder-outline"></i>
                        <span data-key="t-dashboard">Master Data</span>
                    </a>
                </li>
                @endif
                
                <li>
                    <a href="#" onclick="logout()" class="nav-link">
                        <i class="mdi mdi-logout"></i>
                        <span data-key="t-dashboard">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->