@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Schedule Maintenance</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Schedule Maintenance
                                </span>
                            </div>

                            @can('maintenance-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('schedule-maintenances.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Schedule Maintenance
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="maintenanceTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    @if(auth()->user()->can('maintenance-detail') || auth()->user()->can('maintenance-edit') || auth()->user()->can('maintenance-delete'))
                                    <th width="35%">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule_maintenances as $schedule_maintenance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $schedule_maintenance->code }}</td>
                                    <td>{{ $schedule_maintenance->name }}</td>
                                    <td>
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
                                    </td>
                                    @if(auth()->user()->can('maintenance-delete') || auth()->user()->can('maintenance-detail') || auth()->user()->can('maintenance-edit'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('maintenance-edit')
                                            <a href="{{ route('schedule-maintenances.edit', $schedule_maintenance->id) }}" class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endcan

                                            @can('maintenance-detail')
                                            <a href="{{ route('schedule-maintenances.show', $schedule_maintenance->id) }}" class="btn btn-info text-white">
                                                <i class="fa fa-eye"></i>
                                                Show
                                            </a>
                                            @endcan

                                            @can('maintenance-delete')
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Schedule Maintenance', '{{ $schedule_maintenance->name }}', 'schedule-maintenances/' + {{ $schedule_maintenance->id }}, '/schedule-maintenances/')">
                                                <i class="far fa-trash-alt"></i>
                                                Delete
                                            </a>
                                            @endcan
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
</section>
@endsection

@section('script')

@endsection