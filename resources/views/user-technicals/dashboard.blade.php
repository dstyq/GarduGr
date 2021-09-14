@extends('user-technicals.layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_work_orders }}</h3>

                        <p>Today Work Order</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <a href="{{ route('user-technical.work-order') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@endsection