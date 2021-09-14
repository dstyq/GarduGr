@extends('layouts.app')

@section('button')
<div class="btn-group ml-5" role="group">
    @can('work-order-edit')
    <a href="{{ route('work-orders.edit', $work_order->id) }}"
        class="btn btn-warning text-white">
        <i class="far fa-edit"></i>
        Edit
    </a>
    @endcan

    @can('work-order-delete')
    <a href="#" class="btn btn-danger f-12"
        onclick="modalDelete('Work Order', '{{ $work_order->name }}', '/work-orders/' + {{ $work_order->id }}, '/work-orders/')">
        <i class="far fa-trash-alt"></i>
        Delete
    </a>
    @endcan
</div>
@endsection

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('work-orders.index') }}">Work Order</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light mb-0">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Work Order Status</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $work_order->workOrderStatus->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light mb-0">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Asset</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $work_order->asset->name ?? "---" }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light mb-0">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Name</span>
                            <span class="info-box-number text-center text-muted mt-0 mb-0">{{ $work_order->name }}<span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light mb-0">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Priority</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $work_order->priority }}<span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-body">
                    <h3 class="text-primary"><i class="fas fa-map"></i> Description</h3>
                    <p class="text-muted">{{ $work_order->description ?? 'N/A' }}</p>
                    <br>
                    <div class="text-muted">
                        <p class="text-md mb-2">Maintenance Type
                            <b class="d-block">{{ $work_order->maintenanceType->name }}</b>
                        </p>
                        <p class="text-md mb-2">Schedule Maintenance
                            <b
                                class="d-block">{{ $work_order->scheduleMaintenance->name ?? 'Doesnt Have Schedule Maintenance' }}</b>
                        </p>
                        <p class="text-md mb-2">Estimate Completion
                            <b
                                class="d-block">{{ $work_order->suggested_completion_date ? date('d M Y H:i:s', strtotime($work_order->suggested_completion_date)) : 'N/A' }}</b>
                        </p>
                        <p class="text-md mb-2">Actual Completion
                            <b
                                class="d-block">{{ $work_order->actual_completion_date ? date('d M Y H:i:s', strtotime($work_order->actual_completion_date)) : 'N/A' }}</b>
                        </p>
                        <p class="text-md mb-1 mt-2">Task Groups
                            @if($work_order->taskGroups->count() > 0)
                            <ul class="pl-4">
                                @foreach ($work_order->taskGroups as $taskGroup)
                                <li class="mb-2">
                                    <b class="mr-2">{{ $taskGroup->name }} </b> <button onclick="detailModal('Detail Tasks', '/task-groups/' + {{ $taskGroup->id }}, 'large')" class="btn btn-sm btn-primary"><i class="ion ion-eye"></i> Task</button>
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <b class="d-block">Doesn't have task Group</b>
                            @endif
                        </p>
                        <p class="text-md mb-1 mt-2">User Groups
                            @if($work_order->userGroups->count() > 0)
                            <ul class="pl-4">
                                @foreach ($work_order->userGroups as $userGroup)
                                <li>
                                    <b class="mr-2">{{ $userGroup->name }} </b> <button onclick="detailModal('Detail User Technical', '/user-technical-groups/' + {{ $userGroup->id }}, 'xl')" class="btn btn-sm btn-primary"><i class="ion ion-eye"></i> User</button>
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <b class="d-block">Doesn't have user Group</b>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>   

        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-body">
                    <h3 class="text-primary"><i class="fas fa-map"></i> Completion Notes</h3>
                    <p class="text-muted">{{ $work_order->completion_notes ?? 'N/A' }}</p>
                    <br>
                    <div class="text-muted mb-5">
                        <p class="text-md mb-1 mt-2">Task
                            @if($work_order->tasks->count() > 0)
                            <ul class="pl-4">
                                @foreach ($work_order->tasks as $task)
                                <li>
                                    <b class="">{{ $task->task }} </b> 
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <b class="d-block">Doesn't have task</b>
                            @endif
                        </p>
                        <p class="text-md mb-1 mt-2">User Technical
                            @if($work_order->userTechnicals->count() > 0)
                            <ul class="pl-4">
                                @foreach ($work_order->userTechnicals as $userTechnical)
                                <li>
                                    <b class="">{{ $userTechnical->name }} </b>
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <b class="d-block">Doesn't have user technicals</b>
                            @endif
                        </p>
                    </div>

                    <table class="table table-hover" id="tableImage">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Size</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($work_order->images as $image)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>                                             
                                    <img src="{{ asset('img/work-orders/'.($image->name)) }}" width="100px">
                                </td>
                                <td>{{ ($image->name) ? number_format(filesize(public_path('img/work-orders/' . $image->name)) / 1024, 1) . ' KB' : "0 KB" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <span class="tx-bold text-lg">
                                <i class="icon ion ion-ios-speedometer text-lg"></i>
                                Bill Of Materials
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hover" id="tableMaterial">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Materials</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($work_order->asset->boms as $bom)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bom->name }}</td>
                                <td>
                                    <button onclick="detailModal('Detail Material', '/boms/' + {{ $work_order->asset->id }} + '/' + {{ $bom->id }}, 'large')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> View Materials</button>
                                </td>
                                <td>{{ $bom->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <span class="tx-bold text-lg">
                                <i class="icon ion ion-ios-speedometer text-lg"></i>
                                Reference Documents
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hover" id="tableReferenceDocument">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Filename</th>
                                <th>Size</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($work_order->documents as $document)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>                                             
                                    <a href="{{ asset('docs/'.$document->filename) }}">
                                        {{ Str::limit($document->filename ?? "N/A", 45, '...') }}
                                    </a> 
                                </td>
                                <td>{{ ($document->filename) ? number_format(filesize(public_path('docs/' . $document->filename)) / 1024, 1) . ' KB' : "0 KB" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    <!-- /.card -->
</section>
@endsection

@section('script')

@endsection