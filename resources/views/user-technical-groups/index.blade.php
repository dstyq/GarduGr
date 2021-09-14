@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">User Technical Groups</li>
@endsection

@section('style')
    
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    User Technical Groups
                                </span>
                            </div>

                            @can('user-group-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('user-technical-groups.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    User Technical Group
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table class="table table-hover" id="taskGroupTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    @can('bom-detail')
                                    <th>User Technical</th>
                                    @endcan
                                    <th>Description</th>
                                    @if(auth()->user()->can('user-group-delete') ||
                                    auth()->user()->can('user-group-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($user_technical_groups as $user_technical_group)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user_technical_group->name }}</td>
                                    @can('bom-detail')
                                    <td>
                                        <button onclick="detailModal('Detail User Technical', 'user-technical-groups/' + {{ $user_technical_group->id }}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> View User</button>
                                    </td>
                                    @endcan
                                    <td>{{ $user_technical_group->description }}</td>
                                    @if(auth()->user()->can('user-group-delete') ||
                                    auth()->user()->can('user-group-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @if(auth()->user()->can('user-group-edit'))
                                            <a href="{{ route('user-technical-groups.edit', $user_technical_group->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endif

                                            @if(auth()->user()->can('user-group-delete'))
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('User Technical Group', '{{ $user_technical_group->name }}', 'user-technical-groups/' + {{ $user_technical_group->id }})">
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
                </div>
            </div> <!-- Zero Configuration  Ends-->
        </div>
    </div> <!-- /.container-fluid -->
</section>
@endsection

@section('script')

@endsection