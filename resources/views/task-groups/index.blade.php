@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Task Groups</li>
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
                                    Task Group
                                </span>
                            </div>

                            @if (auth()->user()->can('task-group-list'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('task-groups.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    Task Group
                                </a>
                            </div>
                            @endif
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
                                    <th>Tasks</th>
                                    @endcan
                                    <th>Description</th>
                                    @if(auth()->user()->can('bom-delete') ||
                                    auth()->user()->can('bom-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($task_groups as $task_group)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task_group->name }}</td>
                                    @can('bom-detail')
                                    <td>
                                        <button onclick="detailModal('Detail Tasks', 'task-groups/' + {{ $task_group->id }}, 'large')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> View Tasks</button>
                                    </td>
                                    @endcan
                                    <td>{{ $task_group->description }}</td>
                                    @if(auth()->user()->can('bom-delete') ||
                                    auth()->user()->can('bom-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('task-group-edit'))
                                            <a href="{{ route('task-groups.edit', $task_group->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endif

                                            @if (auth()->user()->can('task-group-delete'))
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Task Group', '{{ $task_group->name }}', 'task-groups/' + {{ $task_group->id }})">
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