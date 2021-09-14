@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Bill Of Material</li>
@endsection

@section('style')
    
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Bom
                                </span>
                            </div>

                            @if (auth()->user()->can('bom-list'))
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('boms.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i> 
                                    Bom
                                </a>
                            </div>
                            @endif
                        </div>

                        @include('components.flash-message')

                    </div>

                    <div class="card-body">
                        <table class="table table-hover" id="bomTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    @can('bom-detail')
                                    <th>Materials</th>
                                    @endcan
                                    <th>Description</th>
                                    @if(auth()->user()->can('bom-delete') ||
                                    auth()->user()->can('bom-edit'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($boms as $bom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bom->name }}</td>
                                    @can('bom-detail')
                                    <td>
                                        <button onclick="detailModal('Detail Material', 'boms/' + {{ $bom->id }}, 'large')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> View Materials</button>
                                    </td>
                                    @endcan
                                    <td>{{ $bom->description }}</td>
                                    @if(auth()->user()->can('bom-delete') ||
                                    auth()->user()->can('bom-edit'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('bom-edit'))
                                            <a href="{{ route('boms.edit', $bom->id) }}"
                                                class="btn btn-warning text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                            @endif

                                            @if (auth()->user()->can('bom-delete'))
                                            <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Bom', '{{ $bom->name }}', 'boms/' + {{ $bom->id }})">
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
            </div> <!-- Zero Configuration  Ends-->
        </div>
    </div> <!-- /.container-fluid -->
</section>
@endsection

@section('script')

@endsection