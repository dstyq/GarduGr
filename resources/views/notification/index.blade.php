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
                                <div class="col-6">
                                    <span class="tx-bold font-size-18 text-lg">
                                        <i class="mdi mdi-bell font-size-20 text-lg"></i>&nbsp;
                                        Notification Log
                                    </span>
                                </div>

                                <div class="col-6">
                                    <form action="" method="get">
                                        <select name="notification" id="">
                                            <option value="all">All</option>
                                            <option value="nvr" {{ Request::get('notification') == 'nvr' ? 'selected' : '' }}>NVR</option>
                                            <option value="access_door" {{ Request::get('notification') == 'access_door' ? 'selected' : '' }}>Access Door</option>
                                        </select>

                                        <input type="date" name="start_from" value="{{ date('Y-m-d', strtotime(Request::get('start_from') ?? 'today')) }}">
                                        <input type="date" name="end_from" value="{{ date('Y-m-d', strtotime(Request::get('end_from') ?? 'today')) }}">

                                        <input type="submit" value="send">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                @include('components.flash-message')
                            </div>
                        </div>
                    </div>

                    {{-- {{ dd(Storage::disk('c-drive')->get('Users\Acer\Downloads\screencapture-cctv-monitoring-test-users-1-edit-2021-11-05-14_46_54.png')) }} --}}
                    {{-- <img src="{{ '..'.Storage::disk('c-drive')->url('\Users\Acer\Downloads\screencapture-cctv-monitoring-test-users-1-edit-2021-11-05-14_46_54.png') }}" height="1000px"  width="100px"alt="" srcset=""> --}}
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
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $notif->type ?? 'N/A' }}</td>
                                    <td>{{ $notif->datetime ?? 'N/A' }}</td>
                                    <td>{{ $notif->getLocation()->name }}</td>
                                    <td>{{ $notif->getStatus() }}</td>
                                    <td>{{ $notif->picture ?? 'N/A' }}</td>
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