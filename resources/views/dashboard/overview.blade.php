@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Overview</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $asset_count }}</h3>

                        <p>Assets</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-archive"></i>
                    </div>

                    <a href="{{ route('assets.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $schedule_maintenance_count }}</h3>

                        <p>Maintenances</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-tools"></i>
                    </div>

                    <a href="{{ route('schedule-maintenances.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $bom_count }}</h3>

                        <p>Bom</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-th"></i>
                    </div>

                    <a href="{{ route('boms.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-header text-white">
                <h3 class="card-title">Work Order Statistics</h3>
            </div>

            <div class="card-body">
                <div class="chart">
                    <canvas id="workOrderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<script>
    let chartConfig = {
        labels  : @json($work_order_count['date']),
        datasets: [
            {
                label               : 'Work Order',
                backgroundColor     : 'rgba(0,0,0,0)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius         : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : @json($work_order_count['value'])
            }
        ]
    }
    
    let workOrderChart = $('#workOrderChart').get(0).getContext('2d')
    let chartData = $.extend(true, {}, chartConfig)

    let chartOptions = {
        responsive           : true,
        maintainAspectRatio  : false,
        datasetFill          : false,
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Day'
                }
            }],
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                    steps: 2,
                    stepValue: 2,
                    precision: 0
                }
            }]
        },
    }

    const lineChart = new Chart(workOrderChart, {
      type: 'line',
      data: chartData,
      options: chartOptions
    })
</script>
@endsection