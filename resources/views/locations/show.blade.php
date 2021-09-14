@extends('layouts.app')

@section('button')
<div class="btn-group ml-5" role="group">
    @can('location-edit')
    <a href="{{ route('locations.edit', $location->id) }}"
        class="btn btn-warning text-white">
        <i class="far fa-edit"></i>
        Edit
    </a>
    @endcan

    @can('location-delete')
    <a href="#" class="btn btn-danger f-12"
        onclick="modalDelete('Location', '{{ $location->city }}', '/locations/' + {{ $location->id }}, '/locations/')">
        <i class="far fa-trash-alt"></i>
        Delete
    </a>
    @endcan
</div>
@endsection

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Location</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('style')
<style>
    .maps {
        height: 26rem;
    }
</style>
@endsection

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="card">
        
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Country</span>
                                    <span class="info-box-number text-center text-muted mt-0 mb-0">{{ $location->country }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Province</span>
                                    <span class="info-box-number text-center text-muted mt-0 mb-0">{{ $location->province }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">City</span>
                                    <span class="info-box-number text-center text-muted mt-0 mb-0">{{ $location->city }}<span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="maps" id="map" width="">
                                @if (!($location->latitude && $location->longitude))
                                    <img src="{{ asset('img/no-data.jpg') }}" class="mx-auto d-block" width="100%" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-map"></i> Address</h3>
                    <p class="text-muted">{{ $location->address }}</p>
                    <br>
                    <div class="text-muted">
                        <p class="text-sm">Name
                            <b class="d-block">{{ $location->name }}</b>
                        </p>
                        <p class="text-sm">Category
                            <b class="d-block">{{ $location->locationCategory->name ?? '-' }}</b>
                        </p>
                        <p class="text-sm">Postal Code
                            <b class="d-block">{{ $location->postal_code }}</b>
                        </p>
                        <p class="text-sm">Latitude
                            <b class="d-block">{{ $location->latitude ?? 'N/A' }}</b>
                        </p>
                        <p class="text-sm">Longitude
                            <b class="d-block">{{ $location->longitude ?? 'N/A' }}</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
@endsection

@section('script')
<script>
    function displayMapAt(lat, lon, zoom) {
        $("#map")
            .html(
                "<iframe id=\"map_frame\" "
                        + "width=\"100%\" height=\"100%\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" allowfullscreen "
                        + "src=\"https://maps.google.com/maps?q="
                        + lat + "," + lon
                        + "&z="
                        + zoom + "&output=embed\"" + "></iframe>");
    }

    displayMapAt({{$location->latitude}}, {{$location->longitude}},16);     
</script>
@endsection