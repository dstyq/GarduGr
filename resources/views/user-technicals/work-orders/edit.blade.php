@extends('user-technicals.layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('work-orders.index') }}">Work Order</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')
<style>
    .document {
        width: 100%;
        height: 15.2rem;
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
                        <h3 class="card-title">Edit Work Order</h3>
                    </div>

                    <form method="POST" action="{{ route('user-technical.work-order-update', $work_order->id) }}" enctype="multipart/form-data" id="form">
                        @method('patch')
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') ?? $work_order->name }}"
                                            placeholder="Enter name" readonly>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <small>(Optional)</small></label>
                                        <textarea name="description"
                                            readonly
                                            class="form-control form-control-sm @error('description') is-invalid @enderror"
                                            id="description" cols="30" rows="3"
                                            placeholder="Enter description">{{old('description') ?? $work_order->description}}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Schedule Mainenance</label>
                                                <select
                                                    class="form-control form-control-sm  @error('schedule_maintenance_id') is-invalid @enderror"
                                                    name="schedule_maintenance_id" disabled>
                                                    <option disabled value="0">No Schedule Maintenance</option>
                                                    @foreach ($schedule_maintenances as $schedule_maintenance)
                                                    <option value="{{ $schedule_maintenance->id }}"
                                                        {{ (old('schedule_maintenance_id') ?? $work_order->schedule_maintenance_id == $schedule_maintenance->id) ? 'selected' : '' }}>
                                                        {{ $schedule_maintenance->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('schedule_maintenance_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control form-control-sm  @error('priority') is-invalid @enderror"
                                                    name="priority" disabled>
                                                    <option disabled selected>Choose Priority</option>
                                                    <option value="lowest"
                                                        {{ ((old('priority') ?? $work_order->priority) == 'lowest') ? 'selected' : '' }}>
                                                        Lowest</option>
                                                    <option value="low"
                                                        {{ ((old('priority') ?? $work_order->priority) == 'low') ? 'selected' : '' }}>
                                                        Low</option>
                                                    <option value="medium"
                                                        {{ ((old('priority') ?? $work_order->priority) == 'medium') ? 'selected' : '' }}>
                                                        Medium</option>
                                                    <option value="high"
                                                        {{ ((old('priority') ?? $work_order->priority) == 'high') ? 'selected' : '' }}>
                                                        High</option>
                                                    <option value="highest"
                                                        {{ ((old('priority') ?? $work_order->priority) == 'highest') ? 'selected' : '' }}>
                                                        Highest</option>
                                                </select>
                                                @error('priority')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Work Order Status</label>
                                                <select
                                                    class="form-control form-control-sm  @error('work_order_status_id') is-invalid @enderror"
                                                    name="work_order_status_id">
                                                    <option disabled selected>Choose Work Order Status</option>
                                                    @foreach ($work_order_statuses as $work_order_status)
                                                    <option value="{{ $work_order_status->id }}"
                                                        {{ ((old('work_order_status_id') ?? $work_order->work_order_status_id) == $work_order_status->id) ? 'selected' : '' }}>
                                                        {{ $work_order_status->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('work_order_status_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Maintenance Type</label>
                                                <select
                                                    disabled
                                                    class="form-control form-control-sm  @error('maintenance_type_id') is-invalid @enderror"
                                                    name="maintenance_type_id">
                                                    <option disabled selected>Choose Maintenance Type</option>
                                                    @foreach ($maintenance_types as $maintenances_type)
                                                    <option value="{{ $maintenances_type->id }}"
                                                        {{ ((old('maintenance_type_id') ?? $work_order->maintenance_type_id) == $maintenances_type->id) ? 'selected' : '' }}>
                                                        {{ $maintenances_type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('maintenance_type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Asset</label>
                                                <select class="form-control form-control-sm  @error('asset_id') is-invalid @enderror"
                                                    name="asset_id" disabled>
                                                    <option selected disabled>Choose Asset</option>
                                                    @foreach ($assets as $asset)
                                                    <option value="{{ $asset['id'] }}"
                                                        {{ ((old('asset_id') ?? $work_order->asset_id) == $asset['id']) ? 'selected' : '' }}>
                                                        {{ $asset['name'] }}</option>
                                                    @endforeach
                                                </select>

                                                @error('asset_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="suggested_completion_date">Suggested Completion Date</label>
                                                <input type="datetime-local"
                                                    class="form-control form-control-sm @error('suggested_completion_date') is-invalid @enderror"
                                                    id="suggested_completion_date" name="suggested_completion_date"
                                                    value="{{ old('suggested_completion_date') ?? ($work_order->suggested_completion_date ? date('Y-m-d\TH:i',strtotime($work_order->suggested_completion_date)) : date('Y-m-d\TH:i')) }}"
                                                    placeholder="Enter sugested completion" readonly>

                                                @error('suggested_completion_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="actual_completion_date">Actual Completion Date</label>
                                                <input type="datetime-local"
                                                    class="form-control form-control-sm @error('actual_completion_date') is-invalid @enderror"
                                                    id="actual_completion_date" name="actual_completion_date"
                                                    value="{{ old('actual_completion_date') ?? date('Y-m-d\TH:i',strtotime(($work_order->actual_completion_date ?? date('Y-m-d\TH:i')))) }}"
                                                    placeholder="Enter Actual Completion">

                                                @error('actual_completion_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="completion_notes">Completion Notes</label>
                                        <textarea name="completion_notes"
                                            class="form-control form-control-sm @error('completion_notes') is-invalid @enderror"
                                            id="completion_notes" cols="30" rows="3"
                                            placeholder="Enter Completion Notes">{{old('completion_notes') ?? $work_order->completion_notes}}</textarea>

                                        @error('completion_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="document">
                                        <div class="form-group increment">
                                            <label for="">Images</label>
                                            <div class="input-group">
                                                <input
                                                    class="form-control {{ $errors->has('images') ? 'is-invalid' : '' }}"
                                                    type="file" name="images[]" accept="image/*">

                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-primary btn-add">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Check old values --}}
                                        @if(!empty($work_order->images))
                                        @foreach (($work_order->images) as $image)
                                        <div class="test">
                                            <div class="input-group mt-2">
                                                <a href="{{ asset('img/work-orders/'.$image->name) }}"
                                                    class="form-control form-control-sm text-bold">
                                                    {{ Str::limit($image->name ?? "N/A", 33, '...') }}
                                                </a>
                                                <input type="text" name="prev_images[]" value="{{ $image->id }}"
                                                    class="hidden">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-danger btn-remove">
                                                        <i class="fas fa-minus-square"></i>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                        @endif

                                        <div class="clone invisible">
                                            <div class="test">
                                                <div class="input-group mt-3">
                                                    <input
                                                        class="form-control form-control-sm {{ $errors->has('images') ? 'is-invalid' : '' }}"
                                                        type="file" name="images[]" accept="image/*">

                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-danger btn-remove">
                                                            <i class="fas fa-minus-square"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr width="100%">

                                <div class="row col-12">
                                    <div class="col-md-7">
                                        {{-- <div class="form-group col-lg-12">
                                            <label for="">User Technical</label>

                                            <table id="userTechnicalTable" class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">Avatar</th>
                                                        <th>Username</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="">User Group</label>

                                            <table id="userTechnicalGroupTable" class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                        </div> --}}

                                        <div class="form-group col-lg-12">
                                            <label for="">Reference Documents</label>

                                            <table id="referenceDocumentTable" class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">No</th>
                                                        <th>Filename</th>
                                                        <th>Size</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($work_order->documents as $document)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>                                             
                                                        <a href="{{ asset('docs/'.$document->filename) }}">
                                                            {{ Str::limit($document->filename ?? "N/A", 45, '...') }}
                                                        </a> 
                                                    </td>
                                                    <td>{{ ($document->filename) ? number_format(filesize(public_path('docs/' . $document->filename)) / 1024, 1) . ' KB' : "0 KB" }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="">Materials</label> 
                                            {{-- <a href="#" class="float-right" onclick="changeMaterial()">Change material</a> --}}

                                            <table id="tableMaterial" class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">No</th>
                                                        <th>Name</th>
                                                        <th width="1%">Action</th>
                                                        <th>prevId</th>
                                                        <th>newId</th>
                                                        <th>bomName</th>
                                                        <th>materialName</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-5 pl-0 pr-0">
                                        <label>Tasks</label>
                                        <div style="background: #0f096a;padding-top: 10px;padding-bottom: 10px;border-radius:4px;">
                                            <ul class="todo-list" data-widget="todo-list" style="padding-right: 7.5px;padding-left: 7.5px;">
                                                @foreach ($work_order->reportTaskWorkOrders->sortBy('id') as $task)
                                                <li>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" value="true" name="{{ $task->id }}" id="{{ $task->id }}" {{ ((old($task->id) ?? $task->status) ? 'checked' : '') }} onchange="onCbChange(this)">
                                                        <label for="{{ $task->id }}"></label>
                                                    </div>
                                                    <span class="text">{{ $task->task_name }}</span>
                                                    <small class="badge badge-info"><i class="far fa-clock"></i> {{ $task->time_estimate . ' minutes' ?? '-' }} </small>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    @if (old('prev_material'))
                                        @foreach (old('prev_material') as $key => $prevMaterial)
                                            <input type="hidden" class="prev_material" name="prev_material[]" value="{{ $prevMaterial }}">
                                            <input type="hidden" class="new_material" name="new_material[]" value="{{ old('new_material')[$key] }}">
                                            <input type="hidden" class="remarks" name="remarks[]" value="{{ old('remarks')[$key] }}">
                                            <input type="hidden" class="work_order_id" name="work_order_id[]" value="{{ old('work_order_id')[$key] }}">
                                            <input type="hidden" class="new_name" name="new_name[]" value="{{ old('new_name')[$key] }}">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-footer" onclick="validateTask()">Save</button>
                            <a href="{{ route('user-technical.work-order') }}"
                                class="btn btn-secondary btn-footer">Back</a>
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
    var user_technical_table;
    var user_technicals;
    var id_user_technicals = [];
    var user_technical_group_table;
    var reference_document_table;
    var material_table;
    var user_technical_groups;
    var id_user_technical_groups = [];
    var report_asset_materials = [];

    $(document).ready(function () {
        $(".btn-add").click(function () {
            let markup = $(".invisible").html();
            $(".increment").append(markup);
        });

        $("body").on("click", ".btn-remove", function () {
            $(this).parents(".test").remove();
        });

        user_technical_table = $("#userTechnicalTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        user_technical_group_table = $("#userTechnicalGroupTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        reference_document_table = $("#referenceDocumentTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false
        });

        material_table = $("#tableMaterial").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "ordering": false,
            "columnDefs": [
            {
                "targets": [ 3, 4, 5, 6 ],
                "visible": false,
                "searchable": false
            },
        ]
        });

        oldValueMaterial();

        @if(old('user_technicals'))
           oldUserTechnicals(@json(old('user_technicals')))
        @elseif ($work_order->userTechnicals->pluck('id'))
            oldUserTechnicals(@json($work_order->userTechnicals->pluck('id')))
        @else
            $.ajax({
                type: 'GET',
                url: '/api/user-technicals',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                },
                success: function (data) {
                    user_technicals = data.data
                    user_technicals.forEach(data => {
                        var option = `<option value="${data.username}">`;
                        $( "#user_technical" ).append( option );
                    });
                },
                error: function (data) {
                    $.alert('Failed!');
                    console.log(data);
                }
            });
        @endif

        @if(old('user_technical_groups'))
           oldUserTechnicalGroups(@json(old('user_technical_groups')))
        @elseif ($work_order->userGroups->pluck('id'))
            oldUserTechnicalGroups(@json($work_order->userGroups->pluck('id')))
        @else
            $.ajax({
                type: 'GET',
                url: '/api/user-technical-groups',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                },
                success: function (data) {
                    user_technical_groups = data.data
                    user_technical_groups.forEach(data => {
                        var option = `<option value="${data.name}">`;
                        $( "#user_technical_group" ).append( option );
                    });
                },
                error: function (data) {
                    $.alert('Failed!');
                    console.log(data);
                }
            });
        @endif
    })  

    async function oldUserTechnicals(ids) 
    {
        var old_user_technical = ids;
        let myPromise = new Promise(function(myResolve, myReject) {
            old_user_technical.forEach(id => {
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "id": id,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        // alert('success')
                        id_user_technicals.push(data.data.id);
                        var img = `<img src="{{asset('img/user-technicals/')}}/${data.data.avatar??'user.png'}" width="40px" class="img-circle">`;
                        var action = `<button type="button" onclick="deleteUser('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                        user_technical_table.row.add([
                            img,
                            data.data.username,                       
                            data.data.phone,      
                            action,                 
                        ]);

                        user_technical_table.draw();
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
            }) 

            myResolve('i Love You 3000')
        });
    }

    async function oldUserTechnicalGroups(ids) 
    {
        var old_user_technical_group = ids;
        let myPromise = new Promise(function(myResolve, myReject) {
            old_user_technical_group.forEach(id => {
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical-group',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "id": id,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        // alert('success')
                        id_user_technical_groups.push(data.data.id);
                        var btn = `<button type="button" onclick="detailModal('Detail User Technical', '/user-technical/show-user-group/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                        var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                        user_technical_group_table.row.add([
                            data.data.name,  
                            btn,
                            action,               
                        ]);
                        user_technical_group_table.draw();
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
            }) 

            myResolve('i Love You 3000')
        });
    }

    function onCbChange(cb) { 
        // console.log($(document.getElementById(cb.id).parentElement.parentElement).addClass('done'));
        var b = document.getElementById(cb.id).checked;
        
        if (b) {
            document.getElementById(cb.id).checked = false;
            $(document.getElementById(cb.id).parentElement.parentElement).addClass('done');

            $.confirm({
                title: 'Confirm!',
                content: 'Do you want to checklist?!',
                buttons: {
                    Ok: function () {
                        $(document.getElementById(cb.id).parentElement.parentElement).addClass('done');
                        document.getElementById(cb.id).checked = true;
                    },
                    Cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            
                        }
                    }
                }
            });
        } else {
            document.getElementById(cb.id).checked = true;
            $(document.getElementById(cb.id).parentElement.parentElement).removeClass('done');

            $.confirm({
                title: 'Confirm!',
                content: 'Do you want to unchecklist?!',
                buttons: {
                    Ok: function () {
                        $(document.getElementById(cb.id).parentElement.parentElement).removeClass('done');
                        document.getElementById(cb.id).checked = false;
                    },
                    Cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            
                        }
                    }
                }
            });
        }
    }

    function validateTask() {
        var tasks = @json($work_order->reportTaskWorkOrders);
        var checked = 0;
        tasks.forEach(element => {
            if (document.getElementById(element.id).checked) {
               checked++;
            }
        });

        if (!checked > 0) {
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: 'Attention!',
                content: 'No tasks are checked',
                type: 'red',
                buttons: {
                    tryAgain: {
                        text: 'Continue',
                        btnClass: 'btn-red',
                        action: function(){
                            $('#form').submit();
                        }
                    },
                    close: function () {
                        
                    }
                }
            });
        } else {
            $('#form').submit();
        }
    }

    $('tbody').on('click', 'tr', function () {
        var dataTable = material_table.row( this ).data();
        var table = material_table.row(this);
        var row = material_table.rows(this)[0];
        
        $.confirm({
            title: 'Change Material',
            content: 'URL:/modal-change-material/' + dataTable[3],
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let new_material, remarks, work_order_id;
                        new_material = this.$content.find('#new_material').val();
                        remarks = this.$content.find('#remarks').val();
                        work_order_id = {{ $work_order->id }};

                        $.ajax({
                            type: 'GET', 
                            url: '/api/materials/' + new_material,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            async: false,
                            success: function (data) {
                                var action = `<button type="button" class="btn btn-md btn-info"><i class="fas fa-exchange-alt"></i></button>`;
                                var name = '<span class="text-danger">' + dataTable[6] +'</span>' + ' <i class="fas fa-sync-alt ml-2 mr-2"></i> ' + '<span class="text-success">' + data.data.name +'</span>' + '<span style="font-size:12px;display: block;color:#453f3f;">' + dataTable[5] + '</span>';
                                table.data([dataTable[0], name, action, dataTable[3], new_material, dataTable[5], dataTable[6]]).draw();

                                let index = report_asset_materials.findIndex((report_asset_material) => {
                                    return report_asset_material[0] == dataTable[3];
                                });

                                if (index >= 0) {
                                    report_asset_materials.splice(index, 1,[dataTable[3], new_material, remarks, work_order_id, data.data.name]);
                                } else {
                                    report_asset_materials.push([dataTable[3], new_material, remarks, work_order_id, data.data.name]);
                                }

                                $('.prev_material').remove()
                                $('.new_material').remove()
                                $('.remarks').remove()
                                $('.work_order_id').remove()
                                $('.new_name').remove()

                                report_asset_materials.forEach(function (value) {
                                    $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'prev_material').attr('name', 'prev_material[]').val(value[0]));
                                    $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'new_material').attr('name', 'new_material[]').val(value[1]));
                                    $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'remarks').attr('name', 'remarks[]').val(value[2]));
                                    $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'work_order_id').attr('name', 'work_order_id[]').val(value[3]));
                                    $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'new_name').attr('name', 'new_name[]').val(value[4]));
                                });
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
                                console.log(data);
                            }
                        });
                    }
                },
                cancelChange: {
                    text: 'Cancel Change',
                    btnClass: 'btn-danger',
                    action: function () {
                        let new_material, remarks, work_order_id;
                        new_material = this.$content.find('#new_material').val();
                        remarks = this.$content.find('#remarks').val();
                        work_order_id = {{ $work_order->id }};

                        let index = report_asset_materials.findIndex((data) => {
                            return data[0] == dataTable[3];
                        });

                        if (index >= 0) {
                            report_asset_materials.splice(index, 1);
                        }

                        var action = `<button type="button" class="btn btn-md btn-info"><i class="fas fa-exchange-alt"></i></button>`;
                        var name = dataTable[6] + '<span style="font-size:12px;display: block;color:#453f3f;">' + dataTable[5] + '</span>';
                        table.data([dataTable[0], name, action, dataTable[3], null, dataTable[5], dataTable[6]]).draw();

                        $('.prev_material').remove()
                        $('.new_material').remove()
                        $('.remarks').remove()
                        $('.work_order_id').remove()

                        report_asset_materials.forEach(function (value) {
                            $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'prev_material').attr('name', 'prev_material[]').val(value[0]));
                            $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'new_material').attr('name', 'new_material[]').val(value[1]));
                            $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'remarks').attr('name', 'remarks[]').val(value[2]));
                            $('#form').append($('<input>').attr('type', 'hidden').attr('class', 'work_order_id').attr('name', 'work_order_id[]').val(value[3]));
                        });
                    }
                },
                close : function () {
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
    
    });

    function oldValueMaterial() {
        material_table.rows().remove().draw();

        let prevMaterials  = [].map.call($('.prev_material'), function( prevMaterial ) {
            return prevMaterial.value;
        });
        let newMaterials  = [].map.call($('.new_material'), function( newMaterial ) {
            return newMaterial.value;
        });
        let remarks  = [].map.call($('.remarks'), function( remark ) {
            return remark.value;
        });
        let workOrderIds  = [].map.call($('.work_order_id'), function( workOrderId ) {
            return workOrderId.value;
        });
        let newNames  = [].map.call($('.new_name'), function( newName ) {
            return newName.value;
        });

        $.ajax({
            type: 'GET', 
            url: '/api/asset-materials/'+{{ $work_order->asset->id }},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            success: function (data) {
                data.data.forEach((material, index) => {
                    let indexArray = prevMaterials.findIndex((data) => {
                        return data == material.id;
                    });

                    if (indexArray >= 0) {
                        var action = `<button type="button" class="btn btn-md btn-info"><i class="fas fa-exchange-alt"></i></button>`;
                        var name = '<span class="text-danger">' + material.material_name +'</span>' + ' <i class="fas fa-sync-alt ml-2 mr-2"></i> ' + '<span class="text-success">' + newNames[indexArray] +'</span>' + '<span style="font-size:12px;display: block;color:#453f3f;">' + material.bom.name + '</span>';
                        material_table.row.add([
                            index + 1,
                            name,                       
                            action,                 
                            material.id,                 
                            newMaterials[indexArray],                 
                            material.bom.name,                 
                            material.material_name,                 
                        ]);

                        material_table.draw();
                    } else {
                        var action = `<button type="button" class="btn btn-md btn-info"><i class="fas fa-exchange-alt"></i></button>`;
                        var name = material.material_name + '<span style="font-size:12px;display: block;color:#453f3f;">' + material.bom.name + '</span>';
                        material_table.row.add([
                            index + 1,
                            name,                       
                            action,                 
                            material.id,                 
                            null,                 
                            material.bom.name,                 
                            material.material_name,                 
                        ]);

                        material_table.draw();
                    }
                });
            },
            error: function (data) {
                $.alert(data.responseJSON.message);
                console.log(data);
            }
        });
    }
</script>
@endsection