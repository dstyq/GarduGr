@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                        <h3 class="card-title text-white">User Edit</h3>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') ?? $user->name }}" placeholder="Enter name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') ?? $user->username }}"
                                    placeholder="Enter username">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') ?? $user->email }}" placeholder="Enter email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Roles</label>
                                <select class="form-control" name="role">
                                    <option disabled selected>Select One Role Only</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        {{ (old('role') ?? $user->getRoleNames()[0] == $role) ? 'selected' : ''  }}>
                                        {{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="avatar">Avatar :</label>
                                <img src="{{ asset('img/users/'.($user->avatar ?? 'user.png')) }}" width="110px"
                                    class="image img" />

                                <div class="input-group mt-3">
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                </div>
                                {{-- <div class="small text-secondary">Kosongkan jika tidak mau diisi</div> --}}
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Save</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-footer">Back</a>
                        </div>
                    </form>
                </div>
            </div>

            @if (Auth::user()->id == $user->id)
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                        <h3 class="card-title text-white">Change Password</h3>
                    </div>
                    <form action="{{ route('users.change-password') }}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="card-body">

                            @include('components.flash-message')

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" placeholder="Password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" value="{{ old('new_password') }}"
                                    placeholder="New Password">
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">Change</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('script')

@endsection