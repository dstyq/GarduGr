@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('access-door.index') }}">Device</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                            <h3 class="card-title text-white">Edit Access Door</h3>
                        </div>

                        <form method="POST" action="{{ route('access-door.update', $access->id) }}">
                            @method('patch')
                            @csrf

                            <div class="card-body">

                                @include('components.form-message')

                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? $access->name }}" placeholder="Enter name">
    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">Link</label>
                                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link')  ?? $access->link }}" placeholder="Enter Link">
    
                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" cols="30" rows="3" placeholder="Enter Address">{{old('address') ?? $access->address}}</textarea>
    
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
    
                                <div class="form-group mb-3">
                                    <label for="address">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="3" placeholder="Enter Description">{{old('description')  ?? $access->description}}</textarea>
    
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Location</label>
                                    <select class="form-control" name="location">
                                        <option selected disabled>Choose Location</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}" {{ ((old('location') ?? ($access->location_id ?? '')) == $location->id) ? 'selected' : '' }}>{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-footer">Save</button>
                                <a href="{{ route('access-door.index') }}" class="btn btn-secondary btn-footer">Back</a>
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