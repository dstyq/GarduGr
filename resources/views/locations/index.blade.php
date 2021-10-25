@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Location</li>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Location
                                </span>
                            </div>

                            @can('location-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('locations.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Location
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="locationTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    @if(auth()->user()->can('location-delete') || auth()->user()->can('location-detail') || auth()->user()->can('location-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $location)
                                <tr>
                                    <td onclick="openMap({{ $location->latitude }}, {{ $location->longitude }})" class="pointer">{{ $loop->iteration }}</td>
                                    <td onclick="openMap({{ $location->latitude }}, {{ $location->longitude }})" class="pointer">{{ Str::limit($location->name, 60, '...') }}</td>
                                    <td onclick="openMap({{ $location->latitude }}, {{ $location->longitude }})" class="pointer">{{ ($location->parent_id) ? 'Sub Location of ' . $location->parent->name : 'Parent'}}</td>
                                    @if(auth()->user()->can('location-delete') || auth()->user()->can('location-edit'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('location-edit')
                                            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endcan

                                            @can('location-delete')
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Location', '{{ $location->city }}', 'locations/' + {{ $location->id }}, '/locations/')">
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