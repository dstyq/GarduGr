@extends('layouts.app')

@section('style')
<style>
    .pointer {
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
                            <div class="col-12">
                                <div class="row align-items-center justify-content-between flex-wrap">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <span class="tx-bold font-size-18 text-lg">
                                            <i class="mdi mdi-bell font-size-20 text-lg"></i>&nbsp;
                                            Notification Log
                                        </span>
                                    </div>
                                    {{-- <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center">
                                        <h5 style="font-weight:800;">{{ $shift[0]['shift'] ?? $shift[1]['shift'] ?? 'SHIFT -' }}</h5>
                                    </div> --}}
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right d-flex justify-content-end">
                                        <form action="" method="get" class="row col-12 text-right">
                                            <input class="form-control" style="width:25%;" type="date" name="start_from" value="{{ date('Y-m-d', strtotime(Request::get('start_from') ?? 'today')) }}">
                                            <input class="form-control" style="width:25%;" type="date" name="end_from" value="{{ date('Y-m-d', strtotime(Request::get('end_from') ?? 'today')) }}">
                                            <select name="notification" id="" class="form-select" style="width:28%;">
                                                <option value="all">All</option>
                                                <option value="nvr" {{ Request::get('notification') == 'nvr' ? 'selected' : '' }}>NVR</option>
                                                <option value="access_door" {{ Request::get('notification') == 'access_door' ? 'selected' : '' }}>Access Door</option>
                                            </select>
                                            <input class="d-inline btn-sm btn-primary" style="width:20%;" type="submit" value="send">
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <span class="tx-bold font-size-18 text-lg">
                                        <i class="mdi mdi-bell font-size-20 text-lg"></i>&nbsp;
                                        Notification Log
                                    </span>
                                </div>

                                <div class="col-6">
                                    <form action="" method="get" class="row">
                                        <div class="col-4">
                                            <select name="notification" id="" class="form-select" style="width:20%;">
                                                <option value="all">All</option>
                                                <option value="nvr" {{ Request::get('notification') == 'nvr' ? 'selected' : '' }}>NVR</option>
                                                <option value="access_door" {{ Request::get('notification') == 'access_door' ? 'selected' : '' }}>Access Door</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" style="width:20%;" type="date" name="start_from" value="{{ date('Y-m-d', strtotime(Request::get('start_from') ?? 'today')) }}">
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" style="width:20%;" type="date" name="end_from" value="{{ date('Y-m-d', strtotime(Request::get('end_from') ?? 'today')) }}">
                                        </div>
                                        <input class="btn btn-primary" type="submit" value="send">
                                    </form>
                                </div> --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                @include('components.flash-message')
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="cctvTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Datetime</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Picture</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notif)
                                {{-- {{ dd($notif) }} --}}
                                @php
                                if($notif->type == "access_door" && $notif->picture != "") {
                                    $method = "openNew('" .$notif->getCctv() ."')";
                                    $href = "#";
                                }elseif ($notif->type == "nvr" && ($notif->status == true || $notif->status == false)){
                                    $method = "openNew('" .$notif->getCctv() ."')";
                                    $href = "#";
                                }else {
                                    $href = "webrun:C:\Program Files (x86)\Rosslare\AxTraxNG Client\Client.exe";
                                    $method = '';
                                }
                                @endphp
                               
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td onclick="{{ $method }}">
                                        <a href="{{ $href }}">{{ $notif->type ?? 'N/A' }}</a>
                                    </td>
                                    <td>{{ $notif->datetime ?? 'N/A' }}</td>
                                    <td>{{ $notif->getLocation() }}</td>
                                    <td>{!! $notif->getStatus() !!}</td>
                                    <td>
                                        @if ($notif->picture != "")
                                            @php
                                                $lastArray = count(explode("\\",$notif->picture)); 
                                                $image =  explode("\\",$notif->picture)[$lastArray-1];
                                                $snapshot =  explode("\\",$notif->picture)[$lastArray-2]; 
                                                $idCam =  explode("\\",$notif->picture)[$lastArray-3];  
                                            @endphp
                                            <a href="http://localhost:1234/{{ $idCam }}/{{ $snapshot }}/{{ $image }}" target="_blank"><img src="http://localhost:1234/{{ $idCam }}/{{ $snapshot }}/{{ $image }}" width="100" height="auto" class="d-block mx-auto" alt=""></a>
                                        @else
                                            <img src="{{ asset('img/no-image.png') }}" width="80" height="auto" class="d-block mx-auto" alt="">
                                        @endif
                                    </td>
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