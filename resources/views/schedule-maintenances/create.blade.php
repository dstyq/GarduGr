@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('schedule-maintenances.index') }}">Schedule Maintenance</a></li>
<li class="breadcrumb-item active">Add</li>
@endsection

@section('style')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <style>
        .document {
            width: 100%;
            height: 25rem;
            overflow-y: scroll;
            padding-right: .5rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Schedule Maintenance</h3>
                    </div>

                    <form method="POST" action="{{ route('schedule-maintenances.store') }}" enctype="multipart/form-data" id="form">
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text"
                                                    class="form-control @error('code') is-invalid @enderror" id="code"
                                                    name="code" value="{{ old('code') ?? $code }}"
                                                    placeholder="Enter code">

                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name') }}"
                                                    placeholder="Enter name">

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="mr-5">Status</label>

                                        <div class="icheck-danger d-inline mr-3">
                                            <input type="radio" name="status" id="paused" {{( old('status')) == "0" ? "checked" : ""}}  value="0">
                                            <label for="paused" class="text-danger">
                                                Paused
                                            </label>
                                        </div>

                                        <div class="icheck-success d-inline mr-5">
                                            <input type="radio" name="status" id="running" {{(old('status')) == "1" ? "checked" : ""}}  value="1">
                                            <label for="running" class="text-success">
                                                Running
                                            </label>
                                        </div>

                                        @error('status')
                                        <span class="text-danger text-sm d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Start date - End date:</label>
                    
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="dateRange" name="date_range" value="{{ old('date_range') }}">
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date"
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    id="start_date" name="start_date" value="{{ old('start_date') }}"
                                                    placeholder="Enter start date">

                                                @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" id="end-date">
                                                <label for="end_date">End Date</label>
                                                <input type="date"
                                                    class="form-control @error('end_date') is-invalid @enderror"
                                                    id="end_date" name="end_date" value="{{ old('end_date') }}"
                                                    placeholder="Enter end date">

                                                @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="description">Description <small>(Optional)</small></label>
                                        <textarea name="description"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            cols="30" rows="3" placeholder="Enter description">{{old('description')}}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Work Order Status</label>
                                                <select class="form-control  @error('work_order_status_id') is-invalid @enderror" name="work_order_status_id">
                                                    <option disabled selected>Choose Work Order Status</option>
                                                    @foreach ($work_order_statuses as $work_order_status)
                                                        <option value="{{ $work_order_status->id }}" {{ (old('work_order_status_id') == $work_order_status->id) ? 'selected' : '' }}>{{ $work_order_status->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('work_order_status_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Maintenance Type</label>
                                                <select class="form-control  @error('maintenance_type_id') is-invalid @enderror" name="maintenance_type_id">
                                                    <option disabled selected>Choose Maintenance Type</option>
                                                    @foreach ($maintenance_types as $maintenances_type)
                                                        <option value="{{ $maintenances_type->id }}" {{ (old('maintenance_type_id') == $maintenances_type->id) ? 'selected' : '' }}>{{ $maintenances_type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('maintenance_type_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control  @error('priority') is-invalid @enderror" name="priority">
                                                    <option disabled selected>Choose Priority</option>
                                                    <option value="lowest" {{ (old('priority') == 'lowest') ? 'selected' : '' }}>Lowest</option>
                                                    <option value="low" {{ (old('priority') == 'low') ? 'selected' : '' }}>Low</option>
                                                    <option value="medium" {{ (old('priority') == 'medium') ? 'selected' : '' }}>Medium</option>
                                                    <option value="high" {{ (old('priority') == 'high') ? 'selected' : '' }}>High</option>
                                                    <option value="highest" {{ (old('priority') == 'highest') ? 'selected' : '' }}>Highest</option>
                                                </select>
                                                @error('priority')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="mr-5 d-block">Schedule</label>

                                        
                                        {{-- <div class="d-inline mr-3">
                                            <input type="radio" name="schedule" onclick="scheduleSwitch();" id="hour" {{( old('schedule')) == "hour" ? "checked" : ""}}  value="hour" checked>
                                            <label for="hour" class="text-secondary">
                                                Hourly
                                            </label>
                                        </div> --}}

                                        <div class="d-inline mr-3">
                                            <input type="radio" name="schedule" onclick="scheduleSwitch();" id="day" {{(old('schedule')) == "day" ? "checked" : ""}}  value="day" checked>
                                            <label for="day" class="text-secondary">
                                                Daily
                                            </label>
                                        </div>

                                        <div class="d-inline mr-3">
                                            <input type="radio" name="schedule" onclick="scheduleSwitch();" id="week" {{(old('schedule')) == "week" ? "checked" : ""}}  value="week">
                                            <label for="week" class="text-secondary">
                                                Weekly
                                            </label>
                                        </div>

                                        <div class="d-inline mr-3">
                                            <input type="radio" name="schedule" onclick="scheduleSwitch();" id="month" {{(old('schedule')) == "month" ? "checked" : ""}}  value="month">
                                            <label for="month" class="text-secondary">
                                                Monthly
                                            </label>
                                        </div>

                                        <div class="d-inline">
                                            <input type="radio" name="schedule" onclick="scheduleSwitch();" id="year" {{(old('schedule')) == "year" ? "checked" : ""}}  value="year">
                                            <label for="year" class="text-secondary">
                                                Yearly
                                            </label>
                                        </div>

                                        @error('schedule')
                                        <span class="text-danger text-sm d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group row hour-group">
                                        <p class="col-2 col-form-label">Every</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('hour') is-invalid @enderror hour"
                                                id="hour-group-hour" name="hour"
                                                value="{{ old('hour') ?? 1 }}"
                                                placeholder="Enter hour" min="0" max="23">                                            
                                        </div>
                                        <p class="col-2 col-form-label">hours</p>
                                    </div> --}}

                                    <div class="form-group row day-group d-none">
                                        <p class="col-2 col-form-label">Every</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('day_of_month') is-invalid @enderror"
                                                id="day-group-day" name="day_of_month"
                                                value="{{ old('day_of_month') ?? 1 }}"
                                                placeholder="Enter day" min="1" max="31" disabled='true'>                                            
                                        </div>
                                        <p class="col-2 col-form-label">days</p>
                                    </div>

                                    <div class="form-group row week-group d-none">
                                        <p class="col-2 col-form-label">Every</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('week') is-invalid @enderror"
                                                id="week-group-week" name="week"
                                                value="{{ old('week') ?? 1 }}"
                                                placeholder="Enter week" min="0" max="60" disabled='true'>                                            
                                        </div>
                                        <p class="col-2 col-form-label">weeks</p>
                                    </div>

                                    <div class="form-group row month-group d-none">
                                        <p class="col-2 col-form-label">Day</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('day_of_month') is-invalid @enderror"
                                                id="month-group-day" name="day_of_month"
                                                value="{{ old('day_of_month') ?? 1 }}"
                                                placeholder="Enter day" min="1" max="31" disabled='true'>                                            
                                        </div>
                                        <p class="col-2 col-form-label">of Every</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('month') is-invalid @enderror"
                                                id="month-group-month" name="month"
                                                value="{{ old('month') ?? 1 }}"
                                                placeholder="Enter month" min="1" max="12" disabled='true'>                                            
                                        </div>
                                        <p class="col-2 col-form-label">months</p>
                                    </div>

                                    <div class="form-group row year-group d-none">
                                        <p class="col-2 col-form-label">Every</p>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('year') is-invalid @enderror"
                                                id="year-group-year" name="year"
                                                value="{{ old('year') ?? 1 }}"
                                                placeholder="Enter year" min="0" max="60" disabled='true'>                                            
                                        </div>
                                        <p class="col-2 col-form-label">years, on</p>
                                        <div class="col-4">
                                            <select class="form-control  @error('month') is-invalid @enderror" name="month" id="year-group-month" disabled='true'>
                                                @foreach ($months as $month)
                                                    <option value="{{ $loop->iteration }}" {{ (old('month') == $loop->iteration) ? 'selected' : '' }}>{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type="number"
                                                class="form-control @error('day_of_month') is-invalid @enderror"
                                                id="year-group-day" name="day_of_month"
                                                value="{{ old('day_of_month') ?? 1 }}"
                                                placeholder="Enter day" min="1" max="31" disabled='true'>                                            
                                        </div>
                                    </div>

                                    <div class="form-group row day-of-week-group d-none">
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="monday" value="1" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("1", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="monday" class="custom-control-label">Monday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="tuesday" value="2" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("2", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="tuesday" class="custom-control-label">Tuesday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="wednesday" value="3" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("3", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="wednesday" class="custom-control-label">Wednesday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="thursday" value="4" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("4", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="thursday" class="custom-control-label">Thursday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="friday" value="5" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("5", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="friday" class="custom-control-label">Friday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                          <input class="custom-control-input day-of-week" type="checkbox" id="saturday" value="6" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("6", old('day_of_week'))) ? ' checked' : '' }}>
                                          <label for="saturday" class="custom-control-label">Saturday</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-3">
                                            <input class="custom-control-input day-of-week" type="checkbox" id="sunday" value="7" name="day_of_week[]" disabled='true' {{ (is_array(old('day_of_week')) && in_array("7", old('day_of_week'))) ? ' checked' : '' }}>
                                            <label for="sunday" class="custom-control-label">Sunday</label>
                                        </div>
                                    </div>

                                    <div class="form-group trigger-time mt-3 d-none">
                                        <label>Trigger Time</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <select class="form-control  @error('hour') is-invalid @enderror" name="hour" id="trigger-time-hour" disabled='true'>
                                                    @for ($i = 0; $i < 24; $i++)
                                                        <option value="{{ $i }}" {{ (old('hour') == $i) ? 'selected' : '' }}>{{ $i . ' : 00'}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Asset</label>
                                        <select class="form-control  @error('asset_id') is-invalid @enderror" name="asset_id">
                                            <option selected disabled>Choose Asset</option>
                                            @foreach ($assets as $asset)
                                                <option value="{{ $asset['id'] }}" {{ (old('asset_id') == $asset['id']) ? 'selected' : '' }}>{{ $asset['name'] }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('asset_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tasks</label> <a href="#" class="float-right" onclick="createTask()">Add new task</a>
        
                                        <div class="select2-purple">
                                            <select class="select2 tasks" name="tasks[]" data-placeholder="Select The Task" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                            
                                            </select>
                                        </div>
        
                                        @error('tasks')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tasks Group</label> <a href="#" class="float-right" onclick="createTaskGroup()">Add new task group</a>
        
                                        <div class="select2-purple">
                                            <select class="select2 task-groups" name="task_groups[]" data-placeholder="Select The Task" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                              
                                            </select>
                                        </div>
        
                                        @error('task_groups')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>                                    
                                </div>

                                <hr width="100%">

                                <div class="row col-12">
                                    <div class="col-md-7">
                                        <div class="form-group col-lg-12">
                                            <label for="">User Technical</label> <a href="#" class="float-right" onclick="createUser()">Add new user</a>
            
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search_user" list="user_technical" id="search_user" autocomplete="off">
                                                <datalist id="user_technical">
        
                                                </datalist>
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-info btn-flat" onclick="addUserTechnical()">Add!</button>
                                                </span>
                                              </div>
                                            <table id="userTechnicalTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">Avatar</th>
                                                        <th>Username</th>
                                                        <th>Phone</th>
                                                        <th width="1%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
        
                                        <div class="form-group col-lg-12">
                                            <label for="">User Group</label> <a href="#" class="float-right" onclick="createUserGroup()">Add new user group</a>
            
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search_user_group" list="user_technical_group" id="search_user_group" autocomplete="off">
                                                <datalist id="user_technical_group">
        
                                                </datalist>
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-info btn-flat" onclick="addUserTechnicalGroup()">Add!</button>
                                                </span>
                                              </div>
                                            <table id="userTechnicalGroupTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>User</th>
                                                        <th width="1%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">Reference Document:</label> <a href="#" class="float-right" onclick="chooseReferenceDocuments()">Choose</a>

                                        <table id="referenceDocumentTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Filename</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                        @if (old('referenceId'))
                                        @foreach (old('referenceId') as $referenceId)
                                            <input type="hidden" class="referenceId" name="referenceId[]" value="{{ $referenceId }}">
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Add</button>
                            <a href="{{ route('schedule-maintenances.index') }}" class="btn btn-secondary btn-footer">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    var user_technical_table;
    var user_technicals;
    var id_user_technicals = [];
    var id_tasks = [];
    var id_task_groups = [];
    var user_technical_group_table;
    var user_technical_groups;
    var id_user_technical_groups = [];
    var reference_document_table;
    $(document).ready(function () {
        const nowDate = new Date();
        const minDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

        //Date range picker
        $('#dateRange').daterangepicker({
            minDate,
            "maxSpan": {
                "years": 1
            },
            "showDropdowns": true,
            "linkedCalendars": false,
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
            },
        });

        $('#hour-group-hour').on('keyup',function(){
            v = parseInt($(this).val());
            min = parseInt($(this).attr('min'));
            max = parseInt($(this).attr('max'));

            if (v < min){
                $(this).val(min);
            } else if (v > max){
                $(this).val(max);
            }
        })

        $('#day-group-day').on('keyup',function(){
            v = parseInt($(this).val());
            min = parseInt($(this).attr('min'));
            max = parseInt($(this).attr('max'));

            if (v < min){
                $(this).val(min);
            } else if (v > max){
                $(this).val(max);
            }
        })

        user_technical_table = $("#userTechnicalTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        user_technical_group_table = $("#userTechnicalGroupTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        reference_document_table = $("#referenceDocumentTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        oldValueReferenceDocuments();

        @if (old('task_groups'))
            id_task_groups = @json(old('task_groups'));
            taskGroupOption(id_task_groups);
        @else
            taskGroupOption([]);
        @endif

        @if (old('tasks'))
            id_tasks = @json(old('tasks'));
            taskOption(id_tasks);
        @else
            taskOption([]);
        @endif
        
        @if(old('user_technicals'))
           oldUserTechnicals(@json(old('user_technicals')))
        @else
            $.ajax({
                type: 'GET',
                url: '/api/user-technicals',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                },
                success: function (data) {
                    user_technicals = data.data
                    user_technicals.forEach(data => {
                        var option = `<option value="${data.username}">${data.email}</option>`;
                        $( "#user_technical" ).append( option );
                    });
                },
                error: function (data) {
                    $.alert('Failed!');
                    console.log(data);
                }
            });
        @endif

        @if(old('user_technical_groups'))
           oldUserTechnicalGroups(@json(old('user_technical_groups')))
        @else
            $.ajax({
                type: 'GET',
                url: '/api/user-technical-groups',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                },
                success: function (data) {
                    user_technical_groups = data.data
                    user_technical_groups.forEach(data => {
                        var option = `<option value="${data.name}">${data.users}</option>`;
                        $( "#user_technical_group" ).append( option );
                    });
                },
                error: function (data) {
                    $.alert('Failed!');
                    console.log(data);
                }
            });
        @endif
    })  

    async function oldUserTechnicals(ids) 
    {
        var old_user_technical = ids;
        let myPromise = new Promise(function(myResolve, myReject) {
            old_user_technical.forEach(id => {
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "id": id,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        // alert('success')
                        id_user_technicals.push(data.data.id);
                        var img = `<img src="{{asset('img/user-technicals/')}}/${data.data.avatar??'user.png'}" width="40px" class="img-circle">`;
                        var action = `<button type="button" onclick="deleteUser('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                        user_technical_table.row.add([
                            img,
                            data.data.username,                       
                            data.data.phone,      
                            action,                 
                        ]);

                        user_technical_table.draw();
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
            }) 

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        userTechnicalOption();
    }

    async function oldUserTechnicalGroups(ids) 
    {
        var old_user_technical_group = ids;
        let myPromise = new Promise(function(myResolve, myReject) {
            old_user_technical_group.forEach(id => {
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical-group',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "id": id,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        // alert('success')
                        id_user_technical_groups.push(data.data.id);
                        var btn = `<button type="button" onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                        var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                        user_technical_group_table.row.add([
                            data.data.name,  
                            btn,
                            action,               
                        ]);

                        user_technical_group_table.draw();
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
            }) 

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        userTechnicalGroupOption();
    }

    async function userTechnicalOption() {
        let myPromise2 = new Promise(function(myResolve, myReject) {
            var node= document.getElementById("user_technical");
            node.innerHTML = "";
            myResolve('i Love You 2000')
        });
        console.log(await myPromise2);

        $.ajax({
            type: 'GET',
            url: '/api/user-technicals',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                user_technicals = data.data
                user_technicals.forEach(data => {                    
                    if (!id_user_technicals.includes(data.id)) {
                        console.log('add', data.id);;
                        var option = `<option value="${data.username}">${data.email}</option>`;
                        $( "#user_technical" ).append( option );   
                    }
                });

                id_user_technicals.forEach((id, i) => {
                    var tag = `<input type="text" name="user_technicals[${i}]" value="${id}" class="d-none user_technicals"/>`
                    $( "#form" ).append( tag );  
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
        $('#search_user').val('')  
    }

    async function userTechnicalGroupOption() {
        let myPromise2 = new Promise(function(myResolve, myReject) {
            var node= document.getElementById("user_technical_group");
            node.innerHTML = "";
            myResolve('i Love You 2000')
        });
        console.log(await myPromise2);

        $.ajax({
            type: 'GET',
            url: '/api/user-technical-groups',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                user_technical_groups = data.data
                user_technical_groups.forEach(data => {                    
                    if (!id_user_technical_groups.includes(data.id)) {
                        console.log('add', data.id);
                        var option = `<option value="${data.name}">${data.users}</option>`;
                        $( "#user_technical_group" ).append( option );   
                    }
                });

                id_user_technical_groups.forEach((id, i) => {
                    var tag = `<input type="text" name="user_technical_groups[${i}]" value="${id}" class="d-none user_technical_groups"/>`
                    $( "#form" ).append( tag );  
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
        $('#search_user_group').val('')  
    }

    function createTask() {
        $.confirm({
            title: 'Create Task',
            content: 'URL:/tasks/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let task, time_estimate, description;
                        task = this.$content.find('#task').val();
                        time_estimate = this.$content.find('#time_estimate').val();
                        description = this.$content.find('#description').val();

                        $.ajax({
                            type: 'POST',
                            url: '/tasks',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "task": task,
                                "time_estimate": time_estimate,
                                "description": description,
                                "from": 'work_order'
                            },
                            success: function (data) {
                                id_tasks = [];
                                $.each($(".tasks option:selected"), function(){            
                                    id_tasks.push($(this).val());
                                });
                                taskOption(id_tasks)
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    async function taskOption(taskSelected) {
        $( 'select[name="tasks[]"]' ).text('');
        $.ajax({
            type: 'GET',
            url: '/api/tasks',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                tasks = data.data
                tasks.forEach(data => {   
                    var option;
                    if (taskSelected.includes(data.id.toString())) {
                        option = `<option value="${data.id}" selected>${data.task}</option>`;
                    } else {
                        option = `<option value="${data.id}">${data.task}</option>`;
                    }        
                    $( 'select[name="tasks[]"]' ).append( option );
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function createTaskGroup() {
        $.confirm({
            title: 'Create Task Group',
            content: 'URL:/task-groups/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, description, tasks;
                        name = this.$content.find('#name').val();
                        description = this.$content.find('#description').val();
                        tasks = this.$content.find('#e1').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/task-groups',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "description": description,
                                "tasks": tasks,
                                "from": 'work_order'
                            },
                            success: function (data) {
                                id_task_groups = [];
                                $.each($(".task-groups option:selected"), function(){            
                                    id_task_groups.push($(this).val());
                                });
                                taskGroupOption(id_task_groups);
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    async function taskGroupOption(taskGroupSelected) {
        $( 'select[name="task_groups[]"]' ).text('');
        $.ajax({
            type: 'GET',
            url: '/api/task-groups',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                task_groups = data.data
                task_groups.forEach(data => {   
                    var option;
                    if (taskGroupSelected.includes(data.id.toString())) {
                        option = `<option value="${data.id}" selected>${data.name}</option>`;
                    } else {
                        option = `<option value="${data.id}">${data.name}</option>`;
                    }        
                    $( 'select[name="task_groups[]"]' ).append( option );
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function createUser() {
        $.confirm({
            title: 'Create User',
            content: 'URL:/user-technicals/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, username, phone, whatsapp, address, email, password;
                        name = this.$content.find('#name').val();
                        username = this.$content.find('#username').val();
                        phone = this.$content.find('#phone').val();
                        whatsapp = this.$content.find('#whatsapp').val();
                        address = this.$content.find('#address').val();
                        email = this.$content.find('#email').val();
                        password = this.$content.find('#password').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/user-technicals',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "username": username,
                                "phone": phone,
                                "whatsapp": whatsapp,
                                "address": address,
                                "email": email,
                                "password": password,
                                "from": 'schedule_maintenance'
                            },
                            async: false,
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    userTechnicalOption();
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function createUserGroup() {
        $.confirm({
            title: 'Create User Group',
            content: 'URL:/user-technical-groups/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, description, tasks;
                        name = this.$content.find('#name').val();
                        description = this.$content.find('#description').val();
                        users_technicals = this.$content.find('#e1').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/user-technical-groups',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "description": description,
                                "user_technicals": users_technicals,
                                "from": 'schedule_maintenance'
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    userTechnicalGroupOption()
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function addUserTechnical() {
        let username = $('#search_user').val();

        async function addUserToTable() {
            let myPromise = new Promise(function(myResolve, myReject) {
               
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "username": username,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        if (data.data != null) {
                            var index = id_user_technicals.indexOf(parseInt(data.data.id));
                            if (index !== -1) {
                                $.alert("User has been added");
                            } else {
                                id_user_technicals.push(data.data.id);
                                var img = `<img src="{{asset('img/user-technicals/')}}/${data.data.avatar??'user.png'}" width="40px" class="img-circle">`;
                                var action = `<button type="button" onclick="deleteUser('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                user_technical_table.row.add([
                                    img,
                                    data.data.username,                       
                                    data.data.phone,    
                                    action,                   
                                ]);

                                user_technical_table.draw();
                            }
                        } else {
                            $.confirm({
                                title: 'User Not Found!',
                                content: 'Do you want to create a new user?',
                                buttons: {
                                    yes: function () {
                                        $.confirm({
                                        title: 'Create User',
                                        content: 'URL:/user-technicals/create-modal',
                                        columnClass: 'medium',
                                        buttons: {
                                            formSubmit: {
                                                text: 'Submit',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    let name, username, phone, whatsapp, address, email, password;
                                                    name = this.$content.find('#name').val();
                                                    username = this.$content.find('#username').val();
                                                    phone = this.$content.find('#phone').val();
                                                    whatsapp = this.$content.find('#whatsapp').val();
                                                    address = this.$content.find('#address').val();
                                                    email = this.$content.find('#email').val();
                                                    password = this.$content.find('#password').val();

                                                    $.ajax({
                                                        type: 'POST', 
                                                        url: '/user-technicals',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            "name": name,
                                                            "username": username,
                                                            "phone": phone,
                                                            "whatsapp": whatsapp,
                                                            "address": address,
                                                            "email": email,
                                                            "password": password,
                                                            "from": 'schedule_maintenance'
                                                        },
                                                        async: false,
                                                        success: function (data) {
                                                            console.log(data);
                                                            if (data.status == 200) {
                                                                var index = id_user_technicals.indexOf(parseInt(data.data.id));
                                                                if (index !== -1) {
                                                                    $.alert("User has been added");
                                                                } else {
                                                                    id_user_technicals.push(data.data.id);
                                                                    var img = `<img src="{{asset('img/user-technicals/')}}/${data.data.avatar??'user.png'}" width="40px" class="img-circle">`;
                                                                    var action = `<button type="button" onclick="deleteUser('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                                                    user_technical_table.row.add([
                                                                        img,
                                                                        data.data.username,                       
                                                                        data.data.phone,   
                                                                        action,                    
                                                                    ]);

                                                                    user_technical_table.draw();
                                                                    userTechnicalOption();
                                                                }
                                                            } else {
                                                                let msg = data.msg;
                                                                $.alert(msg);
                                                                return false;
                                                            }
                                                        },
                                                        error: function (data) {
                                                            $.alert(data.responseJSON.message);
                                                            console.log(data);
                                                        }
                                                    });
                                                }
                                            },
                                            cancel: function () {
                                                //close
                                            },
                                        },
                                        onContentReady: function () {
                                            // bind to events
                                            var jc = this;
                                            this.$content.find('form').on('submit', function (e) {
                                                // if the user submits the form by pressing enter in the field.
                                                e.preventDefault();
                                                jc.$$formSubmit.trigger('click'); // reference the button and click it
                                            });
                                        }
                                    });
                                },
                                no: function () {
                                    
                                },
                            }
                        }); 
                        }
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
               
                myResolve('i Love You 3000')
            });

            console.log(await myPromise);

            userTechnicalOption();
        }

        addUserToTable();
    }

    function addUserTechnicalGroup() {
        let name = $('#search_user_group').val();

        async function addUserGroupToTable() {
            let myPromise = new Promise(function(myResolve, myReject) {  
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical-group',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "name": name,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        if (data.data != null) {
                            var index = id_user_technical_groups.indexOf(parseInt(data.data.id));
                            if (index !== -1) {
                                $.alert("User Group has been added");
                            } else {
                                id_user_technical_groups.push(data.data.id);
                                var btn = `<button type="button" onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                                var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                user_technical_group_table.row.add([
                                    data.data.name,  
                                    btn,
                                    action,         
                                ]);

                                user_technical_group_table.draw();
                            }
                        } else {
                            $.confirm({
                                title: 'User Group Not Found!',
                                content: 'Do you want to create a new user group?',
                                buttons: {
                                    yes: function () {
                                        $.confirm({
                                            title: 'Create User Group',
                                            content: 'URL:/user-technical-groups/create-modal',
                                            columnClass: 'medium',
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Submit',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        let name, description, tasks;
                                                        name = this.$content.find('#name').val();
                                                        description = this.$content.find('#description').val();
                                                        users_technicals = this.$content.find('#e1').val();

                                                        $.ajax({
                                                            type: 'POST', 
                                                            url: '/user-technical-groups',
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            data: {
                                                                "_token": "{{ csrf_token() }}",
                                                                "name": name,
                                                                "description": description,
                                                                "user_technicals": users_technicals,
                                                                "from": 'schedule_maintenance'
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                if (data.status == 200) {
                                                                    var index = id_user_technical_groups.indexOf(parseInt(data.data.id));
                                                                    if (index !== -1) {
                                                                        $.alert("User Group has been added");
                                                                    } else {
                                                                        id_user_technical_groups.push(data.data.id);
                                                                        userTechnicalGroupOption();
                                                                        var btn = `<button onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                                                                        var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                                                        user_technical_group_table.row.add([
                                                                            data.data.name,  
                                                                            btn,
                                                                            action,              
                                                                        ]);

                                                                        user_technical_group_table.draw();
                                                                    }
                                                                } else {
                                                                    let msg = data.msg;
                                                                    $.alert(msg);
                                                                    return false;
                                                                }
                                                            },
                                                            error: function (data) {
                                                                $.alert(data.responseJSON.message);
                                                                console.log(data);
                                                            }
                                                        });
                                                    }
                                                },
                                                cancel: function () {
                                                    //close
                                                },
                                            },
                                            onContentReady: function () {
                                                // bind to events
                                                var jc = this;
                                                this.$content.find('form').on('submit', function (e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });
                                    },
                                    no: function () {
                                        
                                    },
                            }
                        });
                        }
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
               
                myResolve('i Love You 3000')
            });

            console.log(await myPromise);

            userTechnicalGroupOption();
        }

        addUserGroupToTable();
    }

    function chooseReferenceDocuments() {
        $('.referenceId').remove()
        reference_document_table.rows().remove().draw();
        const assetId = $('select[name="asset_id"]').val() ?? 0;
        console.log(assetId);
        $.confirm({
            title: 'Choose reference documents',
            content: 'URL:/api/reference-documents/' + assetId,
            columnClass: 'large',
            buttons: {
                okay: {
                    text: 'Okay',
                    btnClass: 'btn-blue',
                    action: function () {
                        var rows_selected = window.table.column(0).checkboxes.selected();
                        console.log(window.table.column(0));
                        $.each(rows_selected, function(index, id){
                            $('#form').append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('class', 'referenceId')
                                    .attr('name', 'referenceId[]')
                                    .val(id)
                            );
                            
                            $.ajax({
                                type: 'POST', 
                                url: '/api/reference-document/'+id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    "id": id,
                                },
                                async: false,
                                success: function (data) {
                                    console.log(data);
                                    // id_user_technical_groups.push(data.data.id);
                                    reference_document_table.row.add([
                                       data.data.filename.slice(0, 45) + (data.data.filename.length > 45 ? "..." : ""),        
                                    ]);

                                    reference_document_table.draw();
                                },
                                error: function (data) {
                                    $.alert(data.responseJSON.message);
                                    console.log(data);
                                }
                            });
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                table = $('#table1').DataTable({     
                    'columnDefs': [
                        {
                            'targets': 0,
                            'checkboxes': {
                                'selectRow': true
                            }
                        }
                    ],
                    'select': {
                        'style': 'multi',
                    },
                    'searching': false,
                    "paging":   false,
                    "ordering": false,
                    "info":     false
                });
            }
        });
    }

    function oldValueReferenceDocuments() {
        let inputs = $('.referenceId');
        let referenceIds  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        $.each(referenceIds, function(index, id){
            $.ajax({
                type: 'POST', 
                url: '/api/reference-document/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "id": id,
                },
                async: false,
                success: function (data) {
                    console.log(data);
                    reference_document_table.row.add([
                        data.data.filename.slice(0, 45) + (data.data.filename.length > 45 ? "..." : ""),        
                    ]);

                    reference_document_table.draw();
                },
                error: function (data) {
                    $.alert(data.responseJSON.message);
                    console.log(data);
                }
            });
        });
    }

    async function deleteUser(id) {
        $('.user_technicals').remove()
        var index = id_user_technicals.indexOf(parseInt(id));
        var ids = [];
        console.log(id_user_technicals);
        let myPromise = new Promise(function(myResolve, myReject) {
            if (index !== -1) {
                console.log("delete " + index);
                id_user_technicals.splice(index, 1);
                ids = id_user_technicals;
                console.log(id_user_technicals);
            }        

            user_technical_table.rows().remove().draw();

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        if (ids.length > 0) {
            id_user_technicals = [];
            oldUserTechnicals(ids);
        } else {
            userTechnicalOption()
        }
    }

    async function deleteUserGroup(id) {
        $('.user_technical_groups').remove()
        var index = id_user_technical_groups.indexOf(parseInt(id));
        var ids = [];
        let myPromise = new Promise(function(myResolve, myReject) {
            if (index !== -1) {
                id_user_technical_groups.splice(index, 1);
                ids = id_user_technical_groups;
            }        

            user_technical_group_table.rows().remove().draw();

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        if (ids.length > 0) {
            id_user_technical_groups = [];
            oldUserTechnicalGroups(ids);
        } else {
            userTechnicalGroupOption()
        }
    }

    function scheduleSwitch() {
        if ($('input[name="schedule"]:checked').val() == 'hour') {
            $('.hour-group').removeClass('d-none')
            $('.day-group').addClass(' d-none')
            $('.week-group').addClass(' d-none')
            $('.month-group').addClass(' d-none')
            $('.year-group').addClass(' d-none')
            $('.trigger-time').addClass(' d-none')
            $('.day-of-week-group').addClass('d-none')

            $('#trigger-time-hour').attr('disabled', true);
            $('#trigger-time-minute').attr('disabled', true);
            $('#day-group-day').attr('disabled', true);
            $('#week-group-week').attr('disabled', true);
            $('#month-group-day').attr('disabled', true);
            $('.day-of-week').attr('disabled', true);
            $('#year-group-day').attr('disabled', true);
            $('#year-group-month').attr('disabled', true);
            $('#year-group-year').attr('disabled', true);
            $('#month-group-month').attr('disabled', true);
            $('#hour-group-hour').attr('disabled', false);
        } else if($('input[name="schedule"]:checked').val() == 'day'){
            $('.day-group').removeClass('d-none')
            $('.trigger-time').removeClass('d-none')
            // $('.hour-group').addClass('d-none')
            $('.week-group').addClass('d-none')
            $('.month-group').addClass('d-none')
            $('.year-group').addClass('d-none')
            $('.day-of-week-group').addClass('d-none')

            $('#trigger-time-hour').attr('disabled', false);
            $('#trigger-time-minute').attr('disabled', false);
            $('#week-group-week').attr('disabled', true);
            $('#year-group-day').attr('disabled', true);
            $('#year-group-month').attr('disabled', true);
            $('#year-group-year').attr('disabled', true);
            $('#month-group-day').attr('disabled', true);
            $('.day-of-week').attr('disabled', true);
            $('#month-group-month').attr('disabled', true);
            $('#day-group-day').attr('disabled', false);
            // $('#hour-group-hour').attr('disabled', true);
        } else if($('input[name="schedule"]:checked').val() == 'week'){
            $('.trigger-time').removeClass('d-none')
            $('.day-of-week-group').removeClass('d-none')
            $('.week-group').removeClass('d-none')
            $('.day-group').addClass('d-none')
            // $('.hour-group').addClass('d-none')
            $('.month-group').addClass('d-none')
            $('.year-group').addClass('d-none')

            $('#trigger-time-hour').attr('disabled', false);
            $('#trigger-time-minute').attr('disabled', false);
            $('#week-group-week').attr('disabled', false);
            $('#month-group-day').attr('disabled', true);
            $('#year-group-day').attr('disabled', true);
            $('#year-group-month').attr('disabled', true);
            $('#year-group-year').attr('disabled', true);
            $('.day-of-week').attr('disabled', false);
            $('#month-group-month').attr('disabled', true);
            $('#day-group-day').attr('disabled', true);
            // $('#hour-group-hour').attr('disabled', true);
        } else if($('input[name="schedule"]:checked').val() == 'month'){
            $('.trigger-time').removeClass('d-none')
            $('.month-group').removeClass('d-none')
            $('.day-group').addClass('d-none')
            // $('.hour-group').addClass('d-none')
            $('.week-group').addClass('d-none')
            $('.year-group').addClass('d-none')
            $('.day-of-week-group').addClass('d-none')

            $('#trigger-time-hour').attr('disabled', false);
            $('#trigger-time-minute').attr('disabled', false);
            $('#week-group-week').attr('disabled', true);
            $('#year-group-day').attr('disabled', true);
            $('.day-of-week').attr('disabled', true);
            $('#year-group-month').attr('disabled', true);
            $('#year-group-year').attr('disabled', true);
            $('#month-group-day').attr('disabled', false);
            $('#month-group-month').attr('disabled', false);
            // $('#hour-group-hour').attr('disabled', true);
            $('#day-group-day').attr('disabled', true);
        } else if($('input[name="schedule"]:checked').val() == 'year'){
            $('.trigger-time').removeClass('d-none')
            $('.year-group').removeClass('d-none')
            $('.day-group').addClass('d-none')
            $('.week-group').addClass('d-none')
            $('.month-group').addClass('d-none')
            // $('.hour-group').addClass('d-none')
            $('.day-of-week-group').addClass('d-none')

            $('#trigger-time-hour').attr('disabled', false);
            $('#trigger-time-minute').attr('disabled', false);
            $('#month-group-day').attr('disabled', true);
            $('.day-of-week').attr('disabled', true);
            $('#year-group-day').attr('disabled', false);
            $('#year-group-month').attr('disabled', false);
            $('#year-group-year').attr('disabled', true);
            $('#month-group-month').attr('disabled', true);
            $('#week-group-week').attr('disabled', true);
            $('#day-group-day').attr('disabled', true);
            // $('#hour-group-hour').attr('disabled', true);
        }
    }

    scheduleSwitch();
</script>
@endsection