@extends('layouts.app')

@section('button')
<div class="btn-group ml-5" role="group">
    @can('asset-edit')
    <a href="{{ route('assets.edit', $asset->id) }}"
        class="btn btn-warning text-white">
        <i class="far fa-edit"></i>
        Edit
    </a>
    @endcan

    @can('asset-delete')
    <a href="#" class="btn btn-danger f-12"
        onclick="modalDelete('Asset', '{{ $asset->name }}', '/assets/' + {{ $asset->id }}, '/assets/')">
        <i class="far fa-trash-alt"></i>
        Delete
    </a>
    @endcan
</div>
@endsection

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Asset</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('style')
<style>
    .maps {
        height: 26rem;
    }
</style>
@endsection

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="card mb-5">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Code</span>
                                    <span
                                        class="info-box-number text-center text-muted mt-0 mb-0">{{ $asset->code }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Parent</span>
                                    <span
                                        class="info-box-number text-center text-muted mt-0 mb-0">{{ $asset->parent->name ?? "---" }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Name</span>
                                    <span
                                        class="info-box-number text-center text-muted mt-0 mb-0">{{ $asset->name }}<span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-1">
                        <div class="card card-tabs mb-lg-5 col-12">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-image-tab" data-toggle="pill"
                                            href="#custom-tabs-one-image" role="tab"
                                            aria-controls="custom-tabs-one-image" aria-selected="false">Image</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-maps-tab" data-toggle="pill"
                                            href="#custom-tabs-one-maps" role="tab" aria-controls="custom-tabs-one-maps"
                                            aria-selected="true">Location</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-child-tab" data-toggle="pill"
                                            href="#custom-tabs-one-child" role="tab"
                                            aria-controls="custom-tabs-one-child" aria-selected="false">Children</a>
                                    </li>
                                </ul>
                            </div>
                    
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-image" role="tabpanel" aria-labelledby="custom-tabs-one-image-tab" >
                                        <img src="{{ asset('img/assets/'.($asset->image ?? 'noimage.jpg')) }}" style="max-width: 100%" class="image img" />
                                    </div>
                    
                                    <div class="tab-pane fade" id="custom-tabs-one-maps" role="tabpanel" aria-labelledby="custom-tabs-maps-tab">
                                        <div class="maps" id="map" width="">
                                            @if (!(($asset->location->latitude ?? false) && ($asset->location->longitude ?? false)))
                                                <img src="{{ asset('img/no-data.jpg') }}" class="mx-auto d-block" width="100%" alt="">
                                            @endif
                                        </div>

                                        <p class="text-md mt-2 mb-1"><b>Addres :</b>
                                            {{ $asset->location->address ?? '' }}
                                        </p>

                                        <p class="text-md mb-1"><b>Country :</b>
                                            {{ $asset->location->country ?? '' }}
                                        </p>

                                        <p class="text-md mb-1"><b>Province :</b>
                                            {{ $asset->location->province ?? '' }}
                                        </p>

                                        <p class="text-md mb-1"><b>City :</b>
                                            {{ $asset->location->city ?? '' }}
                                        </p>
                                    </div>
                    
                                    <div class="tab-pane fade" id="custom-tabs-one-child" role="tabpanel" aria-labelledby="custom-tabs-one-child-tab">
                                        @if($asset->children->count() > 0)
                                        <p class="text-md mb-1 mt-2">Child
                                            <ul class="pl-4">
                                                @foreach ($asset->children as $child)
                                                <li>
                                                    <a href="{{ route('assets.show', $child->id) }}"
                                                        class="btn-link text-secondary">{{ $child->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </p>
                                        @else
                                            <p class="text-md mb-1 mt-2">Doesn't have child </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="text-primary d-inline"><i class="fas fa-map"></i> Description</h3>
                    <a href="{{ route('asset-reports', $asset->id) }}" target="_blank" class="btn btn-sm btn-default float-right"><i class="fas fa-print"></i> Print</a>

                    <p class="text-muted">{{ $asset->description ?? 'N/A' }}</p>
                    <br>
                    <div class="text-muted">
                        <p class="text-md mb-2">Brand
                            <b class="d-block">{{ $asset->brand }}</b>
                        </p>
                        <p class="text-md mb-2">Model
                            <b class="d-block">{{ $asset->model }}</b>
                        </p>
                        @if (isset($asset->type->name))
                        <p class="text-md mb-2">Type
                            <b class="d-block">{{ $asset->type->name }}</b>
                        </p>
                        @endif
                        @if (isset($asset->category->name))
                        <p class="text-md mb-2">Category
                            <b class="d-block">{{ $asset->category->name }}</b>
                        </p>
                        @endif
                        <p class="text-md mb-2">Price
                            <b class="d-block">{{ "Rp " . number_format($asset->purchase_price,2,',','.') }}</b>
                        </p>
                        <p class="text-md mb-2">Purchase Date
                            <b class="d-block">{{ date('d M Y', strtotime($asset->purchase_at)) }}</b>
                        </p>
                        <p class="text-md mb-2">Status:
                            @if ($asset->status == 0)
                            <span class="ml-3 badge badge-danger">Inactive</span>
                            @else
                            <span class="ml-3 badge badge-success">Active</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card card-primary card-tabs mb-lg-5">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-maintenances-tab" data-toggle="pill"
                        href="#custom-tabs-one-maintenances" role="tab"
                        aria-controls="custom-tabs-one-maintenances" aria-selected="false">Maintenances</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-documents-tab" data-toggle="pill"
                        href="#custom-tabs-one-documents" role="tab" aria-controls="custom-tabs-one-documents"
                        aria-selected="true">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-boms-tab" data-toggle="pill"
                        href="#custom-tabs-one-boms" role="tab"
                        aria-controls="custom-tabs-one-boms" aria-selected="false">Boms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-change-material-history-tab" data-toggle="pill"
                        href="#custom-tabs-one-change-material-history" role="tab"
                        aria-controls="custom-tabs-one-change-material-history" aria-selected="false">Change material history</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-maintenances" role="tabpanel" aria-labelledby="custom-tabs-one-maintenances-tab">
                    <table id="table3" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset->scheduleMaintenances as $schedule_maintenance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $schedule_maintenance->code }}</td>
                                <td>{{ $schedule_maintenance->name }}</td>
                                <td>{{ $schedule_maintenance->priority }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="custom-tabs-one-documents" role="tabpanel" aria-labelledby="custom-tabs-documents-tab">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Filename</th>
                                <th>Size</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($asset->documents as $document)
                            @if ($document->type == 'file')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>                                             
                                    <a href="{{ asset('docs/'.$document->filename) }}">
                                        {{ Str::limit($document->filename ?? "N/A", 45, '...') }}
                                    </a> 
                                </td>
                                <td>{{ ($document->filename) ? number_format(filesize(public_path('docs/' . $document->filename)) / 1024, 1) . ' KB' : "0 KB" }}</td>
                            </tr>
                            @else
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>                                             
                                    <a href="{{ $document->filename }}">
                                        {{ Str::limit($document->filename ?? "N/A", 100, '...') }}
                                    </a> 
                                </td>
                                <td>-</td>
                            </tr>
                            @endif 
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="custom-tabs-one-boms" role="tabpanel" aria-labelledby="custom-tabs-one-boms-tab">
                    <table class="table table-hover" id="table2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                @can('departement-detail')
                                <th>Materials</th>
                                @endcan
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($asset->boms as $bom)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bom->name }}</td>
                                @can('departement-detail')
                                <td>
                                    <button onclick="detailModal('Detail Material', '/boms/' + {{ $asset->id }} + '/' + {{ $bom->id }}, 'large')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> View Materials</button>    
                                </td>
                                @endcan
                                <td>{{ $bom->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="custom-tabs-one-change-material-history" role="tabpanel" aria-labelledby="custom-tabs-one-change-material-history-tab">
                    <table class="table table-hover" id="table4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Work Order</th>
                                <th>Previous Material</th>
                                <th>New Material</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($asset->workOrders->sortByDesc('created_at') as $workOrder)
                            @foreach ($workOrder->reportAssetMaterials->sortByDesc('created_at') as $report)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $workOrder->name }}</td>
                                <td>{{ $report->prevMaterial->material_name }}</td>
                                <td>{{ $report->currentMaterial->material_name }}</td>
                                <td>{{ $report->remarks }}</td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</section>
@endsection

@section('script')
<script>

    function displayMapAt(lat, lon, zoom) {
        $("#map")
            .html(
                "<iframe id=\"map_frame\" "
                        + "width=\"100%\" height=\"100%\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" allowfullscreen "
                        + "src=\"https://maps.google.com/maps?q="
                        + lat + "," + lon
                        + "&z="
                        + zoom + "&output=embed\"" + "></iframe>");
    }

    displayMapAt({{$asset->location->latitude ?? 0}}, {{$asset->location->longitude ?? 0}},16);
    
    function createForm(title, url) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let title, description, asset_id;
                        title = this.$content.find('#title').val();
                        description = this.$content.find('#description').val();
                        asset_id = '{{ $asset->id }}';

                        $.ajax({
                            type: 'POST',
                            url: '/maintenances',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "title": title,
                                "description": description,
                                "asset_id": asset_id
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    $.alert('Success ');
                                    window.location.reload();
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function editForm(title, url, put) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let title, description, asset_id;
                        title = this.$content.find('#title').val();
                        description = this.$content.find('#description').val();
                        asset_id = '{{ $asset->id }}';

                        $.ajax({
                            type: 'PATCH',
                            url: put,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "title": title,
                                "description": description,
                                "asset_id": asset_id
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    $.alert('Success ');
                                    window.location.reload();
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
</script>
@endsection