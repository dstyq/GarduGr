@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departements.index') }}">Departements</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="card card-primary">
                    <div class="card-header text-center" style="background-color: rgb(216, 19, 19);">
                        <h3 class="card-title text-white">Add Departement</h3>
                    </div>
                    <form method="POST" action="{{ route('departements.store') }}" novalidate>
                        @csrf
                        <div class="card-body">

                            @include('components.form-message')

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') }}">

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
                                                @foreach (old('permissions') ?? [] as $id)
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
                                    <span class="text-danger text-sm">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Add</button>
                            <a href="{{ route('departements.index') }}" class="btn btn-secondary btn-footer">Back</a>
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