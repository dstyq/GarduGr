@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Asset</a></li>
<li class="breadcrumb-item active">Add</li>
@endsection

@section('style')
<style>
    .document {
        width: 100%;
        height: 18rem;
        overflow-y: scroll;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Asset</h3>
                    </div>

                    <form method="POST" action="{{ route('assets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="code">Code</label>

                                                <input type="text"
                                                    class="form-control @error('code') is-invalid @enderror" 
                                                    id="code"
                                                    name="code" value="{{ old('code') ?? $code }}"
                                                    placeholder="Enter Code">

                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="name">Name</label>

                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" 
                                                    id="name"
                                                    name="name" value="{{ old('name') }}"
                                                    placeholder="Enter Name">

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="brand">Brand</label>

                                                <input type="text"
                                                    class="form-control @error('brand') is-invalid @enderror" 
                                                    id="brand"
                                                    name="brand" value="{{ old('brand') }}"
                                                    placeholder="Enter brand">

                                                @error('brand')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="model">Model</label>

                                                <input type="text"
                                                    class="form-control @error('model') is-invalid @enderror" 
                                                    id="model"
                                                    name="model" value="{{ old('model') }}"
                                                    placeholder="Enter model">

                                                @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="purchase_price">Purchase Price</label>

                                                <input type="number"
                                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                                    id="purchase_price" name="purchase_price"
                                                    value="{{ old('purchase_price') }}"
                                                    placeholder="Enter purchase price">

                                                @error('purchase_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="purchase_at">Purchase Date</label>

                                                <input type="date"
                                                    class="form-control @error('purchase_at') is-invalid @enderror"
                                                    id="purchase_at" 
                                                    name="purchase_at" 
                                                    value="{{ old('purchase_at') }}"
                                                    placeholder="Enter purchase_at">

                                                @error('purchase_at')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="mr-5">Status</label>

                                        <div class="icheck-success d-inline mr-3">
                                            <input type="radio" name="status" id="active" {{( old('status')) == "1" ? "checked" : ""}}  value="1">

                                            <label for="active" class="text-success">
                                                Active
                                            </label>
                                        </div>

                                        <div class="icheck-danger d-inline">
                                            <input type="radio" name="status" id="Inactive" {{(old('status')) == "0" ? "checked" : ""}}  value="0">

                                            <label for="Inactive" class="text-danger">
                                                Inactive
                                            </label>
                                        </div>

                                        @error('status')
                                        <span class="text-danger text-sm d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <small>(Optional)</small></label>

                                        <textarea name="description"
                                            class="form-control @error('description') is-invalid @enderror" 
                                            id="description"
                                            cols="30" rows="3" 
                                            placeholder="Enter description">{{old('description')}}
                                        </textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category</label>

                                                <select class="form-control  @error('category_id') is-invalid @enderror" name="category_id">
                                                    <option disabled selected>Choose Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ (old('category_id') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Type</label>

                                                <select class="form-control  @error('type_id') is-invalid @enderror" name="type_id">
                                                    <option disabled selected>Choose Type</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}" {{ (old('type_id') == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('type_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Location</label>

                                                <select class="form-control  @error('location_id') is-invalid @enderror" name="location_id">
                                                    <option disabled selected>Choose Location</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}" {{ (old('location_id') == $location->id) ? 'selected' : '' }}>{{ Str::limit($location->name, 28, '...') }}</option>
                                                    @endforeach
                                                </select>

                                                @error('location_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Parent</label>

                                                @if (isset($parent))
                                                <select class="form-control" disabled>
                                                    <option selected>{{ $parent->name }}</option>
                                                </select>

                                                <input type="text" name="parent_id" value="{{ $parent->id }}" class="hidden">
                                                @else
                                                <select class="form-control  @error('parent_id') is-invalid @enderror" name="parent_id">
                                                    <option selected value="0">No Parent</option>
                                                    @foreach ($assets as $asset)
                                                        <option value="{{ $asset->id }}" {{ (old('parent_id') == $asset->id) ? 'selected' : '' }}>{{ $asset->name }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                
                                                @error('parent_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>

                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">Choose Image</label>
                                            </div>
                                        </div>

                                        @error('image')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>         

                                    <div class="form-group">
                                        <label for="">Bill Of Material</label> <br>
                                        <small>Select All</small>
                                        <input type="checkbox" id="checkbox">
        
                                        <div class="select2-purple">
                                            <select class="select2" name="bom_id[]" id="e1" data-placeholder="Select The Bom" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                @foreach ($boms as $bom)
                                                    <option value="{{$bom->id}}" {{ in_array($bom->id, old('bom_id') ?? []) ? 'selected' : '' }}>
                                                        {{$bom->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
        
                                        @error('bom_id')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="card card-tabs mb-lg-5 col-12">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-one-image-tab" data-toggle="pill"
                                                        href="#custom-tabs-one-image" role="tab"
                                                        aria-controls="custom-tabs-one-image" aria-selected="false">Documents</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-maps-tab" data-toggle="pill"
                                                        href="#custom-tabs-one-maps" role="tab" aria-controls="custom-tabs-one-maps"
                                                        aria-selected="true">Link</a>
                                                </li>
                                            </ul>
                                        </div>
                                
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-one-image" role="tabpanel" aria-labelledby="custom-tabs-one-image-tab" >
                                                    <div class="document">
                                                        <div class="form-group increment" id="increment-document">
                                                            <div class="input-group">
                                                                <input class="form-control {{ $errors->has('filename') ? 'is-invalid' : '' }}"  type="file" name="filename[]">
                                                                
                                                                <div class="input-group-append">
                                                                    <button type="button"  class="btn btn-outline-primary btn-add" id="btn-add-document">
                                                                        <i class="fas fa-plus-square"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                        
                                                        <div class="clone invisible" id="invisible-document">
                                                            <div class="parent" id="parent-document">
                                                                <div class="input-group mt-3">
                                                                    <input class="form-control {{ $errors->has('filename') ? 'is-invalid' : '' }}"  type="file" name="filename[]">    
                                                                    
                                                                    <div class="input-group-append">
                                                                        <button type="button"  class="btn btn-outline-danger btn-remove" id="btn-remove-document">
                                                                            <i class="fas fa-minus-square"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <div class="tab-pane fade" id="custom-tabs-one-maps" role="tabpanel" aria-labelledby="custom-tabs-maps-tab">
                                                    <div class="document">
                                                        <div class="form-group increment" id="increment-link">
                                                            <div class="input-group">
                                                                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"  type="text" placeholder="add link" name="link[]">
                                                                
                                                                <div class="input-group-append">
                                                                    <button type="button"  class="btn btn-outline-primary btn-add" id="btn-add-link">
                                                                        <i class="fas fa-plus-square"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                        
                                                        <div class="clone invisible" id="invisible-link">
                                                            <div class="parent" id="parent-link">
                                                                <div class="input-group mt-3">
                                                                    <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"  type="text" placeholder="add link" name="link[]">    
                                                                    
                                                                    <div class="input-group-append">
                                                                        <button type="button"  class="btn btn-outline-danger btn-remove" id="btn-remove-link">
                                                                            <i class="fas fa-minus-square"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Add</button>
                            <a href="{{ route('assets.index') }}" class="btn btn-secondary btn-footer">Back</a>
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
    $(document).ready(function () {
        // Documents
        $("#btn-add-document").click(function () {
            let markup = $("#invisible-document").html();
            $("#increment-document").append(markup);
        });

        $("body").on("click", "#btn-remove-document", function () {
            $(this).parents("#parent-document").remove();
        });

        // Link
        $("#btn-add-link").click(function () {
            let markup = $("#invisible-link").html();
            $("#increment-link").append(markup);
        });

        $("body").on("click", "#btn-remove-link", function () {
            $(this).parents("#parent-link").remove();
        });
    })
</script>
@endsection