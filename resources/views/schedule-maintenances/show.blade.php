@extends('layouts.app')

@section('button')
<div class="btn-group ml-5" role="group">
    @can('maintenance-edit')
    <a href="{{ route('schedule-maintenances.edit', $schedule_maintenance->id) }}"
        class="btn btn-warning text-white">
        <i class="far fa-edit"></i>
        Edit
    </a>
    @endcan

    @can('maintenance-delete')
    <a href="#" class="btn btn-danger f-12"
        onclick="modalDelete('Schedule Maintenance', '{{ $schedule_maintenance->name }}', '/schedule-maintenances/' + {{ $schedule_maintenance->id }}, '/schedule-maintenances/')">
        <i class="far fa-trash-alt"></i>
        Delete
    </a>
    @endcan
</div>
@endsection

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('schedule-maintenances.index') }}">Schedule Maintenance</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="row mb-5">
        

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                        <h3 class="text-primary"><i class="fas fa-map"></i> Description</h3>
                        <p class="text-muted">{{ $schedule_maintenance->description ?? 'N/A' }}</p>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-muted">
                                    <p class="text-md mb-2">Maintenance Type
                                        <b class="d-block">{{ $schedule_maintenance->maintenanceType->name }}</b>
                                    </p>
                                    <p class="text-md mb-2">Work Order Status
                                        <b class="d-block">{{ $schedule_maintenance->workOrderStatus->name }}</b>
                                    </p>
                                    <p class="text-md mb-2">Start Date
                                        <b class="d-block">{{ date('d M Y', strtotime($schedule_maintenance->start_date)) }}</b>
                                    </p>
                                    <p class="text-md mb-2">End Date
                                        <b class="d-block">{{ $schedule_maintenance->end_date ? date('d M Y', strtotime($schedule_maintenance->end_date)) : 'N/A' }}</b>
                                    </p>
                                    <p class="text-md mb-2">Schedule
                                        <b class="d-block">{{ $schedule_maintenance->schedule }}</b>
                                    </p>
                                    @if ($schedule_maintenance->schedule == 'hour')
                                    <p class="text-md mb-2">Every
                                        <b class="d-block">{{ $schedule_maintenance->hour }} hour</b>
                                    </p>
                                    @elseif ($schedule_maintenance->schedule == 'day')
                                    <p class="text-md mb-2">Every
                                        <b class="d-block">{{ $schedule_maintenance->day_of_month }} days, on {{ $schedule_maintenance->hour }}:{{ $schedule_maintenance->minute }} </b>
                                    </p>
                                    @elseif ($schedule_maintenance->schedule == 'week')
                                    @php
                                        $week = '';
                                        foreach (json_decode($schedule_maintenance->day_of_week) as $day_of_week) {
                                            if ($day_of_week == 0) {
                                                $week .= ' sunday ';
                                            } elseif ($day_of_week == 1) {
                                                $week .= ' monday ';
                                            } elseif ($day_of_week == 2) {
                                                $week .= ' tuesday ';
                                            } elseif ($day_of_week == 3) {
                                                $week .= ' wednesday ';
                                            } elseif ($day_of_week == 4) {
                                                $week .= ' thursday ';
                                            } elseif ($day_of_week == 5) {
                                                $week .= ' friday ';
                                            } elseif ($day_of_week == 6) {
                                                $week .= ' saturday ';
                                            }
                                        }
                                    @endphp
                                    <p class="text-md mb-2">Every
                                        <b class="d-block">{{ $schedule_maintenance->week }} weeks, at {{ $week }} on {{ $schedule_maintenance->hour }}:{{ $schedule_maintenance->minute }} </b>
                                    </p>
                                    @elseif ($schedule_maintenance->schedule == 'month')
                                    <p class="text-md mb-2">Every
                                        <b class="d-block">{{ $schedule_maintenance->month }} months, at day {{ $schedule_maintenance->day_of_month }} on {{ $schedule_maintenance->hour }}:{{ $schedule_maintenance->minute }} </b>
                                    </p>
                                    @elseif ($schedule_maintenance->schedule == 'year')
                                    <p class="text-md mb-2">Every
                                        <b class="d-block">{{ $schedule_maintenance->year }} years, at {{ date('d M', strtotime($schedule_maintenance->day_of_month.' '.$schedule_maintenance->month)) }} on {{ $schedule_maintenance->hour }}:{{ $schedule_maintenance->minute }} </b>
                                    </p>
                                    @endif
                                    <p class="text-md mb-2">Status:
                                        @if ($schedule_maintenance->status == 0)
                                        <span class="ml-3 badge badge-danger">Paused</span>
                                        @else
                                        <span class="ml-3 badge badge-success">Running</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 border-left border-right">
                                <div class="text-muted">
                                    <p class="text-md mb-1 mt-2">Task
                                        @if($schedule_maintenance->tasks->count() > 0)
                                        <ul class="pl-4">
                                            @foreach ($schedule_maintenance->tasks as $task)
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
                                        @if($schedule_maintenance->userTechnicals->count() > 0)
                                        <ul class="pl-4">
                                            @foreach ($schedule_maintenance->userTechnicals as $userTechnical)
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
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted">
                                    <p class="text-md mb-1 mt-2">Task Groups
                                        @if($schedule_maintenance->taskGroups->count() > 0)
                                        <ul class="pl-4">
                                            @foreach ($schedule_maintenance->taskGroups as $taskGroup)
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
                                        @if($schedule_maintenance->userGroups->count() > 0)
                                        <ul class="pl-4">
                                            @foreach ($schedule_maintenance->userGroups as $userGroup)
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
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Code</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $schedule_maintenance->code }}</span>
                        </div>
                    </div>
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Asset</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $schedule_maintenance->asset->name ?? "---" }}</span>
                        </div>
                    </div>
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Name</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $schedule_maintenance->name }}<span>
                        </div>
                    </div>
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Priority</span>
                            <span
                                class="info-box-number text-center text-muted mt-0 mb-0">{{ $schedule_maintenance->priority }}<span>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('script')
<script>

</script>
@endsection