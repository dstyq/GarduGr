@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('boms.index') }}">Bill Of Materials</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Bom</h3>
                    </div>
                    
                    <form method="POST" action="{{ route('boms.store') }}" novalidate>
                        @csrf
                        <div class="card-body">

                            @include('components.form-message')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="3" placeholder="Enter description">{{old('description')}}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Materials</label> <br>
                                <small>Select All</small>
                                <input type="checkbox" id="checkbox">

                                <div class="select2-purple">
                                    <select class="select2" name="materials[]" id="e1" data-placeholder="Select The Materials" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                        @foreach ($materials as $material)
                                            <option value="{{$material->id}}" 
                                                @foreach (old('materials') ?? [] as $id)
                                                    @if ($id == $material->id)
                                                        {{ ' selected' }}
                                                    @endif
                                                @endforeach>
                                                {{$material->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('materials')
                                    <span class="text-danger text-sm">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Add</button>
                            <a href="{{ route('boms.index') }}" class="btn btn-secondary btn-footer">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection