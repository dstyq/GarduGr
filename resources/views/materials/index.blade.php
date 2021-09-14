@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Materials</li>
@endsection

@section('style')
    
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
                                    Material
                                </span>
                            </div>

                            @if (auth()->user()->can('material-list'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('materials.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    Material
                                </a>
                            </div>
                            @endif
                        </div>
                       
                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="materialsTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Brand</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        @if(auth()->user()->can('material-delete') || auth()->user()->can('material-edit'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($materials as $material)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $material->name }}</td>
                                        <td>{{ $material->model }}</td>
                                        <td>{{ $material->brand }}</td>
                                        <td>{{ $material->type->name ?? 'N/A' }}</td>
                                        <td>{{ $material->purchase_price }}</td>

                                        @if(auth()->user()->can('material-delete') || auth()->user()->can('material-edit'))
                                        <td>
                                            <div class="btn-group">
                                                @if (auth()->user()->can('material-list'))
                                                <a href="{{ route('materials.edit', $material->id) }}"
                                                    class="btn btn-warning text-white">
                                                    <i class="far fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                                @if (auth()->user()->can('material-delete'))
                                                <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Material', '{{ $material->name }}', 'materials/' + {{ $material->id }})">
                                                    <i class="far fa-trash-alt"></i>
                                                    Delete
                                                </a>
                                                @endif
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

    </div>
</section>
@endsection

@section('script')

@endsection
