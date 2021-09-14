@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Category Assets</li>
@endsection

@section('style')
   
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Category
                                </span>
                            </div>

                            @if (auth()->user()->can('category-create'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('categories.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    Category
                                </a>
                            </div>
                            @endif
                        </div>
                       
                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        @if(auth()->user()->can('category-delete') || auth()->user()->can('category-edit'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>

                                        @if(auth()->user()->can('category-delete') || auth()->user()->can('category-edit'))
                                        <td>
                                            <div class="btn-group">
                                                @if (auth()->user()->can('category-list'))
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-warning text-white">
                                                    <i class="far fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                                @if (auth()->user()->can('category-list'))
                                                <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Category', '{{ $category->name }}', 'categories/' + {{ $category->id }})">
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
