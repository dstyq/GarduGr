@extends('layouts.app')

@section('breadcumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $breadcumb ?? 'Dashboard' }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $breadcumb ?? 'Dashboard' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Start page title -->
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-4">
                <h1 class="font-weight-bold">Welcome to the Dashboard!</h1>
                <p class="text-muted">This is where you can manage your application.</p>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Additional content can be added here -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Overview</h5>
                    <p class="card-text">Here you can find a summary of the application status.</p>
                    <a href="#" class="btn btn-primary">View More</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Activities</h5>
                    <p class="card-text">Check the latest activities and updates.</p>
                    <a href="#" class="btn btn-primary">View More</a>
                </div>
            </div>
        </div>
    </div>
@endsection
