@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Location</a></li>
<li class="breadcrumb-item active">Add</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Location</h3>
                        </div>

                        <form method="POST" action="{{ route('locations.store') }}">
                            @csrf

                            <div class="card-body">

                                @include('components.form-message')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
            
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group ">
                                            <label for="">Latitude</label>
                                            <input class="form-control @error('latitude') is-invalid @enderror" step="any" type="number" name="latitude" id="latitude" placeholder="input latitude" value="{{old('latitude')}}">
    
                                            @error('latitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group ">
                                            <label for="">Longitude</label>
                                            <input class="form-control @error('longitude') is-invalid @enderror" step="any" type="number" name="longitude" id="longitude" placeholder="input longitude" value="{{old('longitude')}}">
    
                                            @error('longitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Parent Location</label>
                                            <select class="form-control" name="parent_location">
                                                <option selected value="">No Parent Location</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}" {{ (old('parent_location') == $location->id) ? 'selected' : '' }}>{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('parent_location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="here-maps" class="form-group mb-3">
                                            <label for="">Pin Location</label>
                                            <div style="height: 21.5rem;" id="mapContainer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-footer">Add</button>
                                <a href="{{ route('locations.index') }}" class="btn btn-secondary btn-footer">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>
</section>
@endsection

@section('script')
<script>
    window.action = "submit"
    window.hereApiKey = "{{ env('HERE_API_KEY') }}"
</script>
<script src="{{ asset('js/here.js') }}"></script>
@endsection