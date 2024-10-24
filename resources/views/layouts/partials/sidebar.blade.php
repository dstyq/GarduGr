<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Menu Title -->
                @if(auth()->user()->can('dashboard') || auth()->user()->can('master-data') || auth()->user()->can('history-log-list') || auth()->user()->can('gardu') || auth()->user()->can('impedansi-trafo'))
                    <li class="menu-title" key="t-menu">Menu</li>
                @endif

                <!-- Dashboard Menu -->
                @if(auth()->user()->can('dashboard'))
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="waves-effect">
                            <i class="fas fa-home"></i>
                            <span key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                @endif

                <!-- Master Data Menu -->
                @if(auth()->user()->can('master-data'))
                    <li>
                        <a href="{{ route('master-data.index') }}" class="waves-effect">
                            <i class="mdi mdi-folder-outline"></i>
                            <span data-key="t-master-data">Master Data</span>
                        </a>
                    </li>
                @endif

                <!-- History Log Menu -->
                @if(auth()->user()->can('history-log-list'))
                    <li>
                        <a href="{{ route('history-log.index') }}" class="waves-effect">
                            <i class="mdi mdi-history"></i>
                            <span data-key="t-history-log">History</span>
                        </a>
                    </li>
                @endif

                <!-- Gardu Menu -->
                @if(auth()->user()->can('gardu')) 
                    <li class="mm-active">
                        <a href="{{ route('gardu.index') }}" class="waves-effect active">
                            <i class="fas fa-building"></i>
                            <span key="t-gardu">Gardu</span>
                        </a>
                    </li>
                @endif

                <!-- Impedansi Trafo Menu -->
                @if(auth()->user()->can('impedansi-trafo')) 
                    <li class="mm-active">
                        <a href="{{ route('impedansi-trafo.index') }}" class="waves-effect active">
                            <i class="fas fa-bolt"></i>
                            <span key="t-impedansi-trafo">Impedansi Trafo</span>
                        </a>
                    </li>
                @endif

                <!-- Logout Menu -->
                <li>
                    <a href="#" onclick="logout()" class="nav-link">
                        <i class="mdi mdi-logout"></i>
                        <span data-key="t-logout">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
