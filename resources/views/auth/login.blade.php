<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.head')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        body  {
            background-image: url({{ asset('img/bg3.jpg.crdownload') }});
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-color: #cccccc;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box" style="border-radius: 50px 20px !important;">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary" style="border-radius: 20px 20px !important;">
            <div class="card-header text-center">
                <img src="https://dev-cctv.grooject.com/public/img/telkom.png" alt="Girl in a jacket" style="height: auto;width: 100%;">
            </div>

            <div class="card-body">
                <p class="login-box-msg text-bold">ACCESS MAPS</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="Username Or Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input name="remember" type="checkbox" id="remember" {{  old('remember') ? 'checked' : ''  }}>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                {{-- <p class="mb-1">
                    <a href="{{ route('user-technical.form-login') }}">Login to user technical</a>
                </p> --}}
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.login-box -->

    @include('layouts.partials.foot')

</body>

</html>