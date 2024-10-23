<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login - </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="http://127.0.0.1:8000/img/assets/noimage.jpg">
    
    <!-- Stylesheets -->
    <link href="http://127.0.0.1:8000/backend/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />
    <link href="http://127.0.0.1:8000/backend/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="http://127.0.0.1:8000/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="http://127.0.0.1:8000/backend/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="http://127.0.0.1:8000/plugins/jquery-confirm/css/jquery-confirm.css" rel="stylesheet">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/ionicons.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .auth-page {
            flex: 1;
            display: flex;
        }
        .bg-right {
            flex: 1;
            background-image: url('http://127.0.0.1:8000/img/gedung-telkom.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-color: #cccccc;
            position: relative;
        }
        .bg-dark {
            position: absolute;
            height: 100%;
            width: 100%;
            right: 0;
            bottom: 0;
            left: 0;
            top: 0;
            opacity: .4;
            background-color: rgb(14, 1, 1);
        }
    </style>
</head>

<body data-topbar="dark">
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5 d-flex align-items-center justify-content-center">
                    <div class="auth-full-page-content p-4">
                        <div class="w-100">
                            <div class="text-center mb-4">
                                <a href="index.html" class="d-block auth-logo">
                                    <img src="http://127.0.0.1:8000/img/logo-grootech.png" alt="Logo" height="100">
                                </a>
                            </div>
                            <div class="auth-content">
                                <div class="text-center">
                                    <h5 class="mb-0 font-telkom">Welcome</h5>
                                    <p class="text-muted mt-2">Sign in to dashboard profile.</p>
                                </div>
                                <form class="mt-4 pt-2" method="POST" action="{{ route('login') }}">
                                    @csrf <!-- Token CSRF Dinamis -->
                                    <div class="form-floating form-floating-custom mb-4">
                                        <input id="username" type="text" class="form-control" name="username" required autofocus placeholder="Enter Username Or Email" autocomplete="username">
                                        <label for="username">Username or Email</label>
                                        <div class="form-floating-icon">
                                            <i data-feather="users"></i>
                                        </div>
                                    </div>

                                    <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                        <input id="password" type="password" class="form-control pe-5" name="password" required placeholder="Enter Password" autocomplete="current-password">
                                        <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                        </button>
                                        <label for="password">Password</label>
                                        <div class="form-floating-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check font-size-15">
                                                <input type="checkbox" id="remember" class="form-check-input">
                                                <label class="form-check-label font-size-13" for="remember">
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
                    </div>
                </div>
                <div class="col-xxl-9 col-lg-8 col-md-7 bg-right">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-dark"></div>
                        <div class="col-12 d-block my-auto text-center">
                            <img src="http://127.0.0.1:8000/img/assets/noimage.jpg" alt="No Image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
