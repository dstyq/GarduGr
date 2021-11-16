<!doctype html>
<html lang="en">

    <head>
    
        @include('layouts.partials.head')
        <style>
            .bg-right{
                background-image: url('img/gedung-telkom.jpg');
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                background-color: #cccccc;
            }
            .bg-dark{
                position:absolute;
                height:100%;
                width:100%;
                right:0;
                bottom:0;
                left:0;
                top:0;
                opacity:.4;
                background-color:rgb(14, 1, 1)
            }
            @font-face {
                font-family: 'Tangerine';
                font-style: normal;
                font-weight: normal;
                src: local('Tangerine'), url('font/Cocon-Regular-Font.otf') format('truetype');
            }
            .font-telkom{
                font-family: 'Tangerine' !important;
            }
        </style>

    </head>

    <body data-topbar="dark">

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="my-auto">
                                        <div class="mb-4 mb-md-5 text-center">
                                            <a href="index.html" class="d-block auth-logo">
                                                <img src="{{ asset('img/telkomsel-logo.png') }}" alt="" height="50">
                                            </a>
                                        </div>
                                        <div class="auth-content">
                                            <div class="text-center">
                                                <h5 class="mb-0 font-telkom">Welcome</h5>
                                                <p class="text-muted mt-2">Sign in to dashboard monitoring.</p>
                                            </div>
                                            <form class="mt-4 pt-2" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-floating form-floating-custom mb-4">
                                                    <input id="username" type="text" class="form-control  @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="Enter Username Or Email">
                                                    <label for="input-username">Username or Email</label>
                                                    <div class="form-floating-icon">
                                                    <i data-feather="users"></i>
                                                    </div>
                                                </div>

                                                <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                    <input id="password-input" type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" required placeholder="Enter Password">
                                                    
                                                    <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                    </button>
                                                    <label for="input-password">Password</label>
                                                    <div class="form-floating-icon">
                                                        <i data-feather="lock"></i>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <div class="form-check font-size-15">
                                                            <input type="checkbox" id="remember" {{  old('remember') ? 'checked' : ''  }}class="form-check-input">
                                                            <label class="form-check-label font-size-13" for="remember-check">
                                                                Remember me
                                                            </label>
                                                        </div>  
                                                    </div>
                                                    
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary w-100 waves-effect waves-light font-telkom" type="submit">Log In</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                            <a href="index.html" class="d-block auth-logo mb-2">
                                            <img src="{{ asset('img/CMM.png') }}" alt="" height="40">
                                        </a>
                                        {{-- <p class="text-muted mt-2">cmm@Copyright2021.</p> --}}
                                        <script>document.write(new Date().getFullYear())</script> © PT. Cahaya Mutiara Mandiri.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7 bg-right">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-dark"></div>
                            <div class="col-12 d-block my-auto text-center">
                                {{-- <img src="{{ asset('img/telkomsel-logo-t.png') }}" width="60" height="auto" alt=""> --}}
                                <h1 class="m-0 font-telkom" style="font-size:60px; color:rgba(212, 25, 25, 0.952); font-weight: 900;">TELKOMSEL</h1>
                                <h2 class="m-0 p-0 font-telkom" style="font-size:40px; color:rgba(255, 255, 255, 0.952);">SMART MONITORING</h2>
                            </div>
                            {{-- <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul> --}}
                            <!-- end bubble effect -->
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>

        <script src="{{ asset('assets/js/pages/feather-icon.init.js') }}"></script>

    </body>

</html>

