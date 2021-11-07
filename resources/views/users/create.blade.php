@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('style')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                            <h3 class="card-title text-white">Add User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                @include('components.form-message')

                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"  placeholder="Enter name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}"  placeholder="Enter username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"  placeholder="Enter email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Role</label>
                                    <select class="form-control" name="role">
                                        <option disabled selected>Select One Role Only</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" {{ (old('role') == $role) ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}"  placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="avatar">Avatar</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="avatar" name="avatar">
                                    </div>
                                    {{-- <div class="small text-secondary">Kosongkan jika tidak mau diisi</div> --}}
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-footer">Add</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-footer">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('script')

@endsection