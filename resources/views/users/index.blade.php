@extends('layouts.app')

@section('breadcumb')
  <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <span class="tx-bold text-lg">
                  <i class="icon ion ion-ios-speedometer text-lg"></i> 
                  Users
                </span>
              </div>

              @can('user-create')
              <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('users.create') }}" class="btn btn-md btn-info">
                  <i class="fa fa-plus"></i> 
                  User
                </a>
              </div>
              @endcan
            </div>

            @include('components.flash-message')

          </div>

          <div class="card-body">
            <table id="userTable" class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                  <th>Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <img src="{{ asset('img/users/'.($user->avatar ?? 'user.png')) }}" width="40px" class="img-circle">
                  </td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username.'('. $user->getRoleNames()[0] .')'}}</td>
                  <td>{{ $user->email }}</td>
                  @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                  <td>
                    <div class="btn-group">
                      @can('user-edit')
                      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning text-white">
                        <i class="far fa-edit"></i>
                        Edit
                      </a>
                      @endcan
                      @if(auth()->user()->can('user-delete') && Auth::user()->id != $user->id)
                      <a href="#" class="btn btn-danger f-12" onclick="modalDelete('User', '{{ $user->username }}', 'users/' + {{ $user->id }}, '/users/')">
                        <i class="far fa-trash-alt"></i>
                        Delete
                      </a>
                      @endif
                    </div>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
@endsection

@section('script')

@endsection