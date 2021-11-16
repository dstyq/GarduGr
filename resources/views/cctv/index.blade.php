@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Device Management CCTV</li>
@endsection

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
                            <div class="col-6">
                                <span class="tx-bold font-size-18 text-lg">
                                    <i class="mdi mdi-cctv font-size-22 text-lg"></i>&nbsp;
                                    Device Management CCTV
                                </span>
                            </div>

                            @can('cctv-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('cctv.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Device
                                </a>
                            </div>
                            @endcan
                        </div>
                        <div class="row">
                            <div class="col-6">
                                @include('components.flash-message')
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="cctvTable" class="table d-none table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Link</th>
                                    <th>Description</th>
                                    @if(auth()->user()->can('cctv-delete') || auth()->user()->can('cctv-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cctv as $c)
                                <tr>
                                    <td onclick="openMap({{ $c->latitude }}, {{ $c->longitude }})" class="pointer">{{ $loop->iteration }}</td>
                                    <td onclick="openMap({{ $c->latitude }}, {{ $c->longitude }})" class="pointer">{{ $c->name }}</td>
                                    <td onclick="openMap({{ $c->latitude }}, {{ $c->longitude }})" class="pointer">{{ $c->location->name ?? 'N/A' }}</td>
                                    <td class="pointer"><a href="{{ $c->link }}" target="blank">{{ $c->link }}</a></td>
                                    <td onclick="openMap({{ $c->latitude }}, {{ $c->longitude }})" class="pointer">{{ Str::limit($c->description, 60, '...') }}</td>
                                    @if(auth()->user()->can('cctv-delete') || auth()->user()->can('cctv-edit'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('cctv-edit')
                                            <a href="{{ route('cctv.edit', $c->id) }}" class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endcan

                                            @can('cctv-delete')
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Cctv', '{{ $c->name }}', 'cctv/' + {{ $c->id }}, '/cctv/')">
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
<script>
    function openMap(latitude, longitude) {
        window.open(`https://www.google.com/maps/search/${latitude},${longitude}`);
    }

    async function checkStatus(ip, id, parentId) {
        $.ajax({
            url:'http://127.0.0.1:1010/checkStatus',
            type: "POST",
            dataType: "json",
            success: function(data) {
                console.log('success');
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    checkStatus()
</script>
@endsection