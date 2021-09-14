@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Type Assets</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Types
                                </span>
                            </div>

                            @if (auth()->user()->can('type-list'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('types.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Type
                                </a>
                            </div>
                            @endif
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="typeTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    @if(auth()->user()->can('type-delete') || auth()->user()->can('type-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->description ?? "N/A"}}</td>
                                    <td>
                                        <img class="" src="{{ asset('img/types/'.($type->image ?? 'noimage.jpg')) }}" alt="image" style="max-width:80px;">
                                    </td>
                                    @if(auth()->user()->can('type-delete') || auth()->user()->can('type-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('type-edit'))
                                            <a href="{{ route('types.edit', $type->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endif

                                            @if (auth()->user()->can('type-delete'))
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Type', '{{ $type->name }}', 'types/' + {{ $type->id }})">
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
</section>
@endsection

@section('script')

@endsection