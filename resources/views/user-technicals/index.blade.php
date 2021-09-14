@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
<li class="breadcrumb-item active">User Technicals</li>
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
                                    User Technicals
                                </span>
                            </div>

                            @can('user-technical-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('user-technicals.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    User Technical
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
                                    <th>Phone</th>
                                    <th>Whatsapp</th>
                                    <th>Address</th>
                                    @if(auth()->user()->can('user-technical-delete') || auth()->user()->can('user-technical-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_technicals as $user_technical)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('img/user-technicals/'.($user_technical->avatar ?? 'user.png')) }}"
                                            width="40px" class="img-circle">
                                    </td>
                                    <td>{{ $user_technical->name }}</td>
                                    <td>{{ $user_technical->username }}</td>
                                    <td>{{ $user_technical->email }}</td>
                                    <td>{{ $user_technical->phone }}</td>
                                    <td>{{ $user_technical->whatsapp }}</td>
                                    <td>{{ $user_technical->address }}</td>
                                    @if(auth()->user()->can('user-technical-delete') || auth()->user()->can('user-technical-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @can('user-technical-edit')
                                            <a href="{{ route('user-technicals.edit', $user_technical->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endcan
                                            @if(auth()->user()->can('user-technical-delete'))
                                            <a href="#" class="btn btn-danger f-12"
                                                onclick="modalDelete('User Technical', '{{ $user_technical->username }}', 'user-technicals/' + {{ $user_technical->id }})">
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