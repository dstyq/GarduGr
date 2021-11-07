<!doctype html>
<html lang="en">
    
    <head>
        @include('layouts.partials.head')
    </head>

    <body class="sidebar-enable" data-sidebar-size="sm">

        <!-- Begin page -->
        <div id="layout-wrapper">
            
            <!-- Navbar -->
            @include('layouts.partials.navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts.partials.sidebar')
            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @yield('content')
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @include('layouts.partials.footer')

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        
        <div id="alert-1" class=" d-none toast d-block mx-auto">
            <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" class="d-block mx-auto" height="20">
            <small style="color: black;" id="locationName"></small>
        </div>

        @include('layouts.partials.foot')
    </body>
</html>
