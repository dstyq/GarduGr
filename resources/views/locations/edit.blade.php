@extends('layouts.app')

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                            <h3 class="card-title text-white">Edit Location</h3>
                        </div>

                        <form method="POST" action="{{ route('locations.update', $location->id) }}">
                            @method('patch')
                            @csrf

                            <div class="card-body">

                                @include('components.form-message')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? $location->name }}" placeholder="Enter name">
            
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label for="">Latitude</label>
                                            <input class="form-control @error('latitude') is-invalid @enderror" step="any" type="number" name="latitude" id="latitude" placeholder="input latitude" value="{{old('latitude') ?? $location->latitude}}">
    
                                            @error('latitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label for="">Longitude</label>
                                            <input class="form-control @error('longitude') is-invalid @enderror" step="any" type="number" name="longitude" id="longitude" placeholder="input longitude" value="{{old('longitude') ?? $location->longitude}}">
    
                                            @error('longitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Parent Location</label>
                                            <select class="form-control" name="parent_location">
                                                <option selected value="">No Parent Location</option>
                                                @foreach ($locations as $locationc)
                                                    <option value="{{ $locationc->id }}" {{ ((old('parent_location') ?? $location->parent_id) == $locationc->id) ? 'selected' : '' }}>{{ $locationc->name }}</option>
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
                                        <div id="here-maps" class="form-group mb-3 mb-3">
                                            <label for="">Pin Location</label>
                                            <div style="height: 21.5rem;" id="mapContainer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-footer">Save</button>
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