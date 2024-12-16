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
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="waves-effect">
                            <i class="fas fa-home"></i>
                            <span key="t-dashboards">Dashboard</span>
                        </a>
                    </li>

                <!-- Master Data Menu -->
                    <li>
                        <a href="{{ route('master-data.index') }}" class="waves-effect">
                            <i class="mdi mdi-folder-outline"></i>
                            <span data-key="t-master-data">Master Data</span>
                        </a>
                    </li>

                <!-- History Log Menu -->
                    <li>
                        <a href="{{ route('history-log.index') }}" class="waves-effect">
                            <i class="mdi mdi-history"></i>
                            <span data-key="t-history-log">History</span>
                        </a>
                    </li>

                <!-- Gardu Menu -->
                    <li>
                        <a href="{{ route('gardu.index') }}" class="waves-effect">
                            <i class="fas fa-building"></i>
                            <span key="t-gardu">Gardu</span>
                        </a>
                    </li>

                <!-- Impedansi Trafo Menu -->
                
                    <li>
                        <a href="{{ route('impedansi-trafo.index') }}" class="waves-effect">
                            <i class="fas fa-bolt"></i>
                            <span key="t-impedansi-trafo">Impedansi Trafo</span>
                        </a>
                    </li>

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
