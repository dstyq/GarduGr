@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="accordion">
                    @foreach ($schedule_maintenances as $schedule_maintenance)
                    <div class="card card-success">
                        <div class="card-header">
                          <div class="row">
                              <div class="col-lg-12">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion-{{ $loop->iteration }}" class="float-right btn btn-md btn-danger">
                                        <i class="fas fa-angle-double-down"></i>
                                        Work Order({{ $schedule_maintenance->workOrders->count() }})
                                    </a>
                                    <a href="{{ route('maintenance-reports', $schedule_maintenance->id) }}" class="float-right btn btn-md btn-info mr-2" target="_blank">
                                        <i class="fas fa-eye"></i>
                                        Maintenance Report
                                    </a>
                                  <span class="text-md">
                                      <span class="text-bold">Maintenance Code :</span> {{ $schedule_maintenance->code }}
                                  </span>
                                  <br>
                                  <span class="text-md">
                                      <span class="text-bold">Maintenance Name :</span> {{ $schedule_maintenance->name }}
                                  </span>
                              </div>
                          </div>
                        </div>
                        <div id="accordion-{{ $loop->iteration }}" class="panel-collapse collapse">
                          <div class="card-body">
                              <table id="table-{{ $loop->iteration }}" class="table table-hover  table-responsive-xl">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Name</th>
                                          <th>Estimate Complete</th>
                                          <th>Actual Complete</th>
                                          <th>Status</th>
                                          <th width="35%">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($schedule_maintenance->workOrders->sortByDesc('created_at')->all() as $work_order)
                                      <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $work_order->name }}</td>
                                          <td>{{ $work_order->suggested_completion_date ?? 'N/A' }}</td>
                                          <td>{{ $work_order->actual_completion_date ?? 'N/A' }}</td>
                                          <td>{{ $work_order->workOrderStatus->name }}</td>
                                          @if(auth()->user()->can('location-delete'))
                                          <td>
                                              <div class="btn-group" role="group">
                                                  @can('location-detail')
                                                  <a href="{{ route('work-order-reports', $work_order->id) }}" class="btn btn-info text-white" target="_blank">
                                                      <i class="fas fa-eye"></i>
                                                      WO Report
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    @foreach ($schedule_maintenances as $schedule_maintenance)
        <script>
            $('#table-' + {{ $loop->iteration }}).DataTable({
                'bLengthChange': false,
                'searching': false,
                "paging":   false,
                "ordering": false,
                "info":     false
            }); 
        </script>
    @endforeach
@endsection