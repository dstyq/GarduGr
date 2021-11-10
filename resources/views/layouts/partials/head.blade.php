<meta charset="utf-8" />
<title>{{($page_title ?? '') . ' - ' .  env('APP_NAME')}} </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('img/telkomsel-logo-t.png') }}">
<link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />

<!-- alertifyjs default themes  Css -->
<link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" />

<!-- preloader css -->
{{-- <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" /> --}}

<!-- Bootstrap Css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />


<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Jquery Confirm -->
<link href="{{ asset('plugins/jquery-confirm/css/jquery-confirm.css') }}" rel="stylesheet">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
{{-- Here Maps --}}
<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link type="text/css" href="{{ asset('css/datatables-checkboxes.css') }}" rel="stylesheet" />
<style>
    /* .btn-footer {
        width: 110px;
    } */
    
    /* Chrome, Safari, Edge, Opera */
    /* input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0; */
    /* } */

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
/*     
    .btn-footer {
        width: 110px;
    }
    
    .img {
        display: block;
        margin: 10px;
    } */
    .hidden {
        display: none !important;
    }
    .topcorner{
        position:absolute;
        top:76px;
        right:17px;
    }
</style>

@yield('style')