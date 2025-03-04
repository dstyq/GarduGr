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
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-4">
                <h1 class="font-weight-bold">Welcome to the Dashboard!</h1>
                <p class="text-muted">:D</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gardu</h5>
                    <p class="card-text">Check Gardu.</p>
                    <a href="{{ route('gardu.index') }}" class="btn btn-primary">View More</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Impedansi Trafo</h5>                    <p class="card-text">Check Impedansi Trafo.</p>
                    <a href="{{ route('impedansi-trafo.index') }}" class="btn btn-primary">View More</a>
                </div>
            </div>
        </div>
    </div>
@endsection
