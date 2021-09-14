@extends('user-technicals.layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Work Orders</li>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
<style>
    tr {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-9">
                                <form action="" method="get" style="">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <select name="daterange" class="form-control" id="daterange">
                                                <option value="day">Day</option>
                                                <option value="month">Month</option>
                                                <option value="year">Year</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3" id="datepicker-area">
                                            <input type="text" name="date" id="date" value="{{$date}}"
                                                autocomplete="off" class="datepicker form-control time"
                                                required>

                                            <input type="text" name="month" id="month" value="{{$month}}"
                                                autocomplete="off" class="datepicker-month form-control d-none time" required>

                                            <input type="text" name="year" id="year" value="{{$year}}"
                                                autocomplete="off" class="datepicker-year form-control  d-none time"
                                                required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="button" onclick="submitDate()"
                                                class="btn btn-success">
                                                <div><i class="fa fa-paper-plane"></i></div>
                                            </button>
                                            <a href="" class="btn btn-danger">
                                                <div><i class="fa fa-sync"></i></div>
                                            </a>
                                        </div>
                                        <div class="form-group col-md-5 d-none" id="loading">
                                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                                            <h4 class="d-inline font-weight-bold">Loading</h4>
                                        </div>

                                        <div class="form-group col-md-5 mb-0" id="result">
                                            <h3 class="d-inline" id="resultData">{{ count($work_orders) }} data</h3>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="workOrderTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Maintenance</th>
                                    <th>priority</th>
                                    <th>Status</th>
                                    <th>Datetime</th>
                                    <th>Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($work_orders as $work_order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $work_order->name }}</td>
                                    <td>{{ $work_order->scheduleMaintenance->name ?? 'N/A'}}</td>
                                    <td>{{ $work_order->priority }}</td>
                                    <td>{{ $work_order->workOrderStatus->name }}</td>
                                    <td>{{ $work_order->date_generate }}</td>
                                    <td>{{ $work_order->id }}</td>
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
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script>
    $('.datepicker').datepicker({
       format: "yyyy-mm-dd",
       startView: 2,
       minViewMode: 0,
       language: "id",
       daysOfWeekHighlighted: "0",
       autoclose: true,
       todayHighlight: true,
       toggleActive: true,
       container: '#datepicker-area'
   });

   $('.datepicker-month').datepicker({
       format: "yyyy-mm",
       startView: 2,
       minViewMode: 1,
       language: "id",
       daysOfWeekHighlighted: "0",
       autoclose: true,
       todayHighlight: true,
       toggleActive: true,
       container: '#datepicker-area'
   });

   $('.datepicker-year').datepicker({
       format: "yyyy",
       startView: 2,
       minViewMode: 2,
       language: "id",
       daysOfWeekHighlighted: "0",
       autoclose: true,
       todayHighlight: true,
       toggleActive: true,
       container: '#datepicker-area'
   });

   $('#daterange').on('change', function () {
       val = $(this).val();
       if (val == 'day') {
           $('.datepicker').removeClass('d-none');
           $('.datepicker-month').addClass('d-none');
           $('.datepicker-year').addClass('d-none');
       } else if (val == 'month') {
           $('.datepicker').addClass('d-none');
           $('.datepicker-month').removeClass('d-none');
           $('.datepicker-year').addClass('d-none');
       } else if (val == 'year') {
           $('.datepicker').addClass('d-none');
           $('.datepicker-month').addClass('d-none');
           $('.datepicker-year').removeClass('d-none');
       }

   })

   const workOrderTable = $('#workOrderTable').DataTable({
       "paging":   true,
       "ordering": true,
       "info":     true,
       "columnDefs": [
           {
               "targets": [ 6 ],
               "visible": false,
               "searchable": false
           },
       ]
   });

   $('tbody').on('click', 'tr', function () {
       var data = workOrderTable.row( this ).data();
       window.location.href = 'work-orders/' + data[6] +'/edit'
   } );

   const submitDate = () => {
       let daterange = $('#daterange').val();
       let date;

        $('#loading').removeClass('d-none');
        $('#result').addClass('d-none');

       if (daterange == 'day') {
           date = $('#date').val()
       } else if (daterange == 'month') {
           date = $('#month').val()
       } else if (daterange == 'year') {
           date = $('#year').val()
       }

       $.ajax({
           type: 'POST', 
           url: '/api/user-technicals/work-orders',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {
               userId: {{ Auth::user()->id }},
               date,
               daterange
           },
           async: false,
           success: function (data) {
                $('#resultData').text(data.data.length + ' data');
               workOrderTable.clear().draw();
               data.data.forEach((value, i) => {
                   workOrderTable.row.add([
                       i+1,
                       value.name,                       
                       (value.schedule_maintenance) ? value.schedule_maintenance.name : 'N/A',                       
                       value.priority,                      
                       (value.work_order_status) ? value.work_order_status.name : 'N/A',                                            
                       value.date_generate,                      
                       value.id,                       
                   ]);

                   workOrderTable.draw();
               });
           },
           error: function (data) {
               $.alert(data.responseJSON.message);
               console.log(data);
           },
           complete: function(){
                setTimeout(() => {
                    $('#loading').addClass('d-none');
                    $('#result').removeClass('d-none');
                }, 300);
            }
       });
   }
</script>
@endsection