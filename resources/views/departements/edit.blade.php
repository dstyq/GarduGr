@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
<li class="breadcrumb-item"><a href="{{ route('departements.index') }}">Departements</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <style>
    .btn-footer {
        width: 110px;
    }
  </style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="card card-primary">
                    <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                        <h3 class="card-title text-white">Edit {{ $departement->name }}</h3>
                    </div>

                    <form method="POST" action="{{ route('departements.update', $departement->id) }}" novalidate>
                        @method('patch')
                        @csrf

                        <div class="card-body">
                            
                            @include('components.form-message')

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') ?? $departement->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Permissions</label> <br>
                                <small>Select All</small>
                                <input type="checkbox" id="checkbox">

                                <div class="select2-purple">
                                    <select class="select2" name="permissions[]" id="e1" data-placeholder="Select The Permissions" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                        @foreach ($permissions as $permission)
                                            <option value="{{$permission->id}}" 
                                                @foreach (old('permissions') ?? $rolePermissions as $id)
                                                    @if ($id == $permission->id)
                                                        {{ ' selected' }}
                                                    @endif
                                                @endforeach>
                                                {{$permission->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                @error('permissions')
                                    <span class="text-danger f-12">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a href="{{ route('departements.index') }}" class="btn btn-secondary">Cancel</a>
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