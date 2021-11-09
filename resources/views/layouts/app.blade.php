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
            
            <div class="topcorner" style="width: 400px;max-height: 400px;padding: 15px;box-shadow: -3px 7px 28px -6px rgba(0,0,0,0.75);-webkit-box-shadow: -3px 7px 28px -6px rgba(0,0,0,0.75);-moz-box-shadow: -3px 7px 28px -6px rgba(0,0,0,0.75);border-radius: 30px;background: white;z-index: 99999999999999999999999999999;"  class="topcorner">
                <img src="" class="imgAccess" width="100%" height="auto" alt="" style="border-radius: 16px;">
                <span class="locationName text-center" style="margin-top:10px;font-size:15px;font-weight:bold;display:block"></span>
                {{-- <small class="font-size-13 locationName" style="color: black;" id="locationName"></small> --}}
            </div>
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
        
        @include('layouts.partials.foot')
    </body>
</html>
