@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Location Category</li>
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
                                    Location Categories
                                </span>
                            </div>

                            @can('location-category-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('location-categories.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Location Category
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table id="typeTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Icon</th>
                                    @if(auth()->user()->can('location-category-delete') || auth()->user()->can('location-category-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($location_categories as $location_category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $location_category->name }}</td>
                                    <td>{{ $location_category->description ?? "N/A"}}</td>
                                    <td>
                                        <img class="" src="{{ asset('img/location-categories/'.($location_category->icon ?? 'noimage.jpg')) }}" alt="image" style="max-width:80px;">
                                    </td>
                                    @if(auth()->user()->can('location-category-delete') || auth()->user()->can('location-category-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @can('location-category-edit')
                                            <a href="{{ route('location-categories.edit', $location_category->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endcan

                                            @can('location-category-delete')
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Location Category', '{{ $location_category->name }}', 'location-categories/' + {{ $location_category->id }}, '/location-categories/')">
                                                <i class="far fa-trash-alt"></i>
                                                Delete
                                            </a>
                                            @endcan
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