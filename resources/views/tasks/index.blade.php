@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Tasks</li>
@endsection

@section('style')
   
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Task
                                </span>
                            </div>

                            @if (auth()->user()->can('task-list'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('tasks.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    Task
                                </a>
                            </div>
                            @endif
                        </div>
                       
                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="taskTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Task</th>
                                        <th>Description</th>
                                        <th>Time Estimate <small>(minutes)</small></th>
                                        @if(auth()->user()->can('category-delete') || auth()->user()->can('category-edit'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task->task }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->time_estimate }}</td>

                                        @if(auth()->user()->can('category-delete') || auth()->user()->can('category-edit'))
                                        <td>
                                            <div class="btn-group">
                                                @if (auth()->user()->can('task-edit'))
                                                <a href="{{ route('tasks.edit', $task->id) }}"
                                                    class="btn btn-warning text-white">
                                                    <i class="far fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                                @if (auth()->user()->can('task-delete'))
                                                <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Task', '{{ $task->task }}', 'tasks/' + {{ $task->id }})">
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
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

@section('script')

@endsection
