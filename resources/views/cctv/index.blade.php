@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">CCTV Management</li>
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
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    CCTV Management
                                </span>
                            </div>

                            @can('cctv-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('cctv.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    CCTV
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="cctvTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
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
                                    <td class="pointer"><a href="chrome-extension://hehijbfgiekmjfkfjpbkbammjbdenadd/nhc.htm#url={{ $c->link }}" target="blank">{{ $c->link }}</a></td>
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
</script>
@endsection