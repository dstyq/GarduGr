@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('work-orders.index') }}">Work Order</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')
    <style>
        .document {
            width: 100%;
            height: 20rem;
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

                    <form method="POST" action="{{ route('work-orders.update', $work_order->id) }}" enctype="multipart/form-data" id="form">
                        @method('patch')
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            name="name" value="{{ old('name') ?? $work_order->name }}"
                                            placeholder="Enter name">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <small>(Optional)</small></label>
                                        <textarea name="description"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            cols="30" rows="3" placeholder="Enter description">{{old('description') ?? $work_order->description}}</textarea>

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
                                                <select class="form-control  @error('schedule_maintenance_id') is-invalid @enderror" name="schedule_maintenance_id">
                                                    <option disabled value="0">No Schedule Maintenance</option>
                                                    @foreach ($schedule_maintenances as $schedule_maintenance)
                                                        <option value="{{ $schedule_maintenance->id }}" {{ (old('schedule_maintenance_id') ?? $work_order->schedule_maintenance_id == $schedule_maintenance->id) ? 'selected' : '' }}>{{ $schedule_maintenance->name }}</option>
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
                                                <select class="form-control  @error('priority') is-invalid @enderror" name="priority">
                                                    <option disabled selected>Choose Priority</option>
                                                    <option value="lowest" {{ ((old('priority') ?? $work_order->priority) == 'lowest') ? 'selected' : '' }}>Lowest</option>
                                                    <option value="low" {{ ((old('priority') ?? $work_order->priority) == 'low') ? 'selected' : '' }}>Low</option>
                                                    <option value="medium" {{ ((old('priority') ?? $work_order->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                                                    <option value="high" {{ ((old('priority') ?? $work_order->priority) == 'high') ? 'selected' : '' }}>High</option>
                                                    <option value="highest" {{ ((old('priority') ?? $work_order->priority) == 'highest') ? 'selected' : '' }}>Highest</option>
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
                                                <select class="form-control  @error('work_order_status_id') is-invalid @enderror" name="work_order_status_id">
                                                    <option disabled selected>Choose Work Order Status</option>
                                                    @foreach ($work_order_statuses as $work_order_status)
                                                        <option value="{{ $work_order_status->id }}" {{ ((old('work_order_status_id') ?? $work_order->work_order_status_id) == $work_order_status->id) ? 'selected' : '' }}>{{ $work_order_status->name }}</option>
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
                                                <select class="form-control  @error('maintenance_type_id') is-invalid @enderror" name="maintenance_type_id">
                                                    <option disabled selected>Choose Maintenance Type</option>
                                                    @foreach ($maintenance_types as $maintenances_type)
                                                        <option value="{{ $maintenances_type->id }}" {{ ((old('maintenance_type_id') ?? $work_order->maintenance_type_id) == $maintenances_type->id) ? 'selected' : '' }}>{{ $maintenances_type->name }}</option>
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
                                                <select class="form-control  @error('asset_id') is-invalid @enderror" name="asset_id">
                                                    <option selected disabled>Choose Asset</option>
                                                    @foreach ($assets as $asset)
                                                        <option value="{{ $asset['id'] }}" {{ ((old('asset_id') ?? $work_order->asset_id) == $asset['id']) ? 'selected' : '' }}>{{ $asset['name'] }}</option>
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="suggested_completion_date">Estimate Completion Date</label>
                                                <input type="datetime-local"
                                                    class="form-control @error('suggested_completion_date') is-invalid @enderror"
                                                    id="suggested_completion_date" name="suggested_completion_date" value="{{ old('suggested_completion_date') ?? ($work_order->suggested_completion_date ? date('Y-m-d\TH:i',strtotime($work_order->suggested_completion_date)) : '') }}"
                                                    placeholder="Enter sugested completion">

                                                @error('suggested_completion_date')
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
                                            class="form-control @error('completion_notes') is-invalid @enderror" id="completion_notes"
                                            cols="30" rows="3" placeholder="Enter Completion Notes">{{old('completion_notes') ?? $work_order->completion_notes}}</textarea>

                                        @error('completion_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Tasks</label> <a href="#" class="float-right" onclick="createTask()">Add new task</a>
        
                                        <div class="select2-purple">
                                            <select class="select2 tasks" name="tasks[]" data-placeholder="Select The Task" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                              
                                            </select>
                                        </div>
        
                                        @error('tasks')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tasks Group</label> <a href="#" class="float-right" onclick="createTaskGroup()">Add new task group</a>
        
                                        <div class="select2-purple">
                                            <select class="select2 task-groups" name="task_groups[]" data-placeholder="Select The Task" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                
                                            </select>
                                        </div>
        
                                        @error('task_groups')
                                        <span class="text-danger text-sm" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <hr width="100%">

                                <div class="row col-12">
                                    <div class="col-md-7">
                                        <div class="form-group col-lg-12">
                                            <label for="">User Technical</label> <a href="#" class="float-right" onclick="createUser()">Add new user</a>
            
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search_user" list="user_technical" id="search_user" autocomplete="off">
                                                <datalist id="user_technical">
        
                                                </datalist>
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-info btn-flat" onclick="addUserTechnical()">Add!</button>
                                                </span>
                                              </div>
                                            <table id="userTechnicalTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">Avatar</th>
                                                        <th>Username</th>
                                                        <th>Phone</th>
                                                        <th width="1%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
        
                                        <div class="form-group col-lg-12">
                                            <label for="">User Group</label> <a href="#" class="float-right" onclick="createUserGroup()">Add new user group</a>
            
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search_user_group" list="user_technical_group" id="search_user_group" autocomplete="off">
                                                <datalist id="user_technical_group">
        
                                                </datalist>
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-info btn-flat" onclick="addUserTechnicalGroup()">Add!</button>
                                                </span>
                                              </div>
                                            <table id="userTechnicalGroupTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>User</th>
                                                        <th width="1%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">Reference Document:</label> <a href="#" class="float-right" onclick="chooseReferenceDocuments()">Choose</a>

                                        <table id="referenceDocumentTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Filename</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                        @if (old('referenceId'))
                                        @foreach (old('referenceId') as $referenceId)
                                            <input type="hidden" class="referenceId" name="referenceId[]" value="{{ $referenceId }}">
                                        @endforeach
                                        @else
                                        @foreach ($work_order->documents as $document)
                                            <input type="hidden" class="referenceId" name="referenceId[]" value="{{ $document->id }}">
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Save</button>
                            <a href="{{ route('work-orders.index') }}" class="btn btn-secondary btn-footer">Back</a>
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
    var id_tasks = [];
    var id_task_groups = [];
    var user_technical_group_table;
    var user_technical_groups;
    var id_user_technical_groups = [];
    var reference_document_table;

    $(document).ready(function () {
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

        oldValueReferenceDocuments();

        @if (old('task_groups'))
            id_task_groups = @json(old('task_groups'));
            taskGroupOption(id_task_groups);
        @elseif ($work_order->taskGroups->pluck('id'))
            id_task_groups = @json($work_order->taskGroups->pluck('id')).map(String);
            taskGroupOption(id_task_groups);
        @else
            taskGroupOption([]);
        @endif

        @if (old('tasks'))
            id_tasks = @json(old('tasks'));
            taskOption(id_tasks);
        @elseif ($work_order->tasks->pluck('id'))
            id_tasks = @json($work_order->tasks->pluck('id')).map(String);
            taskOption(id_tasks);
        @else
            taskOption([]);
        @endif

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
                        var option = `<option value="${data.username}">${data.email}</option>`;
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
                        var option = `<option value="${data.name}">${data.users}</option>`;
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

        console.log(await myPromise);

        userTechnicalOption();
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
                        var btn = `<button type="button" onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
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

        console.log(await myPromise);

        userTechnicalGroupOption();
    }

    async function userTechnicalOption() 
    {
        let myPromise2 = new Promise(function(myResolve, myReject) {
            var node= document.getElementById("user_technical");
            while (node.firstChild) {
                console.log('remove');
                node.removeChild(node.firstChild);
            }
            myResolve('i Love You 2000')
        });
        console.log(await myPromise2);

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
                    if (!id_user_technicals.includes(data.id)) {
                        console.log('add');
                        var option = `<option value="${data.username}">${data.email}</option>`;
                        $( "#user_technical" ).append( option );   
                    }
                });

                id_user_technicals.forEach((id, i) => {
                    var tag = `<input type="text" name="user_technicals[${i}]" value="${id}" class="d-none user_technicals"/>`
                    $( "#form" ).append( tag );  
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
        $('#search_user').val('')  
    }

    async function userTechnicalGroupOption() {
        let myPromise2 = new Promise(function(myResolve, myReject) {
            var node= document.getElementById("user_technical_group");
            while (node.firstChild) {
                console.log('remove');
                node.removeChild(node.firstChild);
            }
            myResolve('i Love You 2000')
        });
        console.log(await myPromise2);

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
                    if (!id_user_technical_groups.includes(data.id)) {
                        console.log('add');
                        var option = `<option value="${data.name}">${data.users}</option>`;
                        $( "#user_technical_group" ).append( option );   
                    }
                });

                id_user_technical_groups.forEach((id, i) => {
                    var tag = `<input type="text" name="user_technical_groups[${i}]" value="${id}" class="d-none user_technical_groups"/>`
                    $( "#form" ).append( tag );  
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
        $('#search_user_group').val('')  
    }

    function createTask() {
        $.confirm({
            title: 'Create Task',
            content: 'URL:/tasks/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let task, time_estimate, description;
                        task = this.$content.find('#task').val();
                        time_estimate = this.$content.find('#time_estimate').val();
                        description = this.$content.find('#description').val();

                        $.ajax({
                            type: 'POST',
                            url: '/tasks',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "task": task,
                                "time_estimate": time_estimate,
                                "description": description,
                                "from": 'work_order'
                            },
                            success: function (data) {
                                id_tasks = [];
                                $.each($(".tasks option:selected"), function(){            
                                    id_tasks.push($(this).val());
                                });
                                taskOption(id_tasks)
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
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

    async function taskOption(taskSelected) {
        $( 'select[name="tasks[]"]' ).text('');
        $.ajax({
            type: 'GET',
            url: '/api/tasks',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                tasks = data.data
                tasks.forEach(data => {   
                    var option;
                    if (taskSelected.includes(data.id.toString())) {
                        option = `<option value="${data.id}" selected>${data.task}</option>`;
                    } else {
                        option = `<option value="${data.id}">${data.task}</option>`;
                    }        
                    $( 'select[name="tasks[]"]' ).append( option );
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function createTaskGroup() {
        $.confirm({
            title: 'Create Task Group',
            content: 'URL:/task-groups/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, description, tasks;
                        name = this.$content.find('#name').val();
                        description = this.$content.find('#description').val();
                        tasks = this.$content.find('#e1').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/task-groups',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "description": description,
                                "tasks": tasks,
                                "from": 'work_order'
                            },
                            success: function (data) {
                                id_task_groups = [];
                                $.each($(".task-groups option:selected"), function(){            
                                    id_task_groups.push($(this).val());
                                });
                                taskGroupOption(id_task_groups);
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
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

    async function taskGroupOption(taskGroupSelected) {
        $( 'select[name="task_groups[]"]' ).text('');
        $.ajax({
            type: 'GET',
            url: '/api/task-groups',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            success: function (data) {
                task_groups = data.data
                task_groups.forEach(data => {   
                    var option;
                    if (taskGroupSelected.includes(data.id.toString())) {
                        option = `<option value="${data.id}" selected>${data.name}</option>`;
                    } else {
                        option = `<option value="${data.id}">${data.name}</option>`;
                    }        
                    $( 'select[name="task_groups[]"]' ).append( option );
                });
            },
            error: function (data) {
                $.alert('Failed!');
                console.log(data);
            }
        });
    }

    function createUser() {
        $.confirm({
            title: 'Create User',
            content: 'URL:/user-technicals/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, username, phone, whatsapp, address, email, password;
                        name = this.$content.find('#name').val();
                        username = this.$content.find('#username').val();
                        phone = this.$content.find('#phone').val();
                        whatsapp = this.$content.find('#whatsapp').val();
                        address = this.$content.find('#address').val();
                        email = this.$content.find('#email').val();
                        password = this.$content.find('#password').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/user-technicals',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "username": username,
                                "phone": phone,
                                "whatsapp": whatsapp,
                                "address": address,
                                "email": email,
                                "password": password,
                                "from": 'work_order'
                            },
                            async: false,
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    userTechnicalOption();
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
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

    function createUserGroup() {
        $.confirm({
            title: 'Create User Group',
            content: 'URL:/user-technical-groups/create-modal',
            columnClass: 'medium',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name, description, tasks;
                        name = this.$content.find('#name').val();
                        description = this.$content.find('#description').val();
                        users_technicals = this.$content.find('#e1').val();

                        $.ajax({
                            type: 'POST', 
                            url: '/user-technical-groups',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": name,
                                "description": description,
                                "user_technicals": users_technicals,
                                "from": 'work_order'
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.status == 200) {
                                    userTechnicalGroupOption()
                                } else {
                                    let msg = data.msg;
                                    $.alert(msg);
                                    return false;
                                }
                            },
                            error: function (data) {
                                $.alert(data.responseJSON.message);
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

    function addUserTechnical() {
        let username = $('#search_user').val();

        async function addUserToTable() {
            let myPromise = new Promise(function(myResolve, myReject) {
               
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "username": username,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        if (data.data != null) {
                            var index = id_user_technicals.indexOf(parseInt(data.data.id));
                            if (index !== -1) {
                                $.alert("User has been added");
                            } else {
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
                            }
                        } else {
                            $.confirm({
                                title: 'User Not Found!',
                                content: 'Do you want to create a new user?',
                                buttons: {
                                    yes: function () {
                                        $.confirm({
                                        title: 'Create User',
                                        content: 'URL:/user-technicals/create-modal',
                                        columnClass: 'medium',
                                        buttons: {
                                            formSubmit: {
                                                text: 'Submit',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    let name, username, phone, whatsapp, address, email, password;
                                                    name = this.$content.find('#name').val();
                                                    username = this.$content.find('#username').val();
                                                    phone = this.$content.find('#phone').val();
                                                    whatsapp = this.$content.find('#whatsapp').val();
                                                    address = this.$content.find('#address').val();
                                                    email = this.$content.find('#email').val();
                                                    password = this.$content.find('#password').val();

                                                    $.ajax({
                                                        type: 'POST', 
                                                        url: '/user-technicals',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            "name": name,
                                                            "username": username,
                                                            "phone": phone,
                                                            "whatsapp": whatsapp,
                                                            "address": address,
                                                            "email": email,
                                                            "password": password,
                                                            "from": 'work_order'
                                                        },
                                                        async: false,
                                                        success: function (data) {
                                                            console.log(data);
                                                            if (data.status == 200) {
                                                                var index = id_user_technicals.indexOf(parseInt(data.data.id));
                                                                if (index !== -1) {
                                                                    $.alert("User has been added");
                                                                } else {
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
                                                                    userTechnicalOption();
                                                                }
                                                            } else {
                                                                let msg = data.msg;
                                                                $.alert(msg);
                                                                return false;
                                                            }
                                                        },
                                                        error: function (data) {
                                                            $.alert(data.responseJSON.message);
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
                                },
                                no: function () {
                                    
                                },
                            }
                        }); 
                        }
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
               
                myResolve('i Love You 3000')
            });

            console.log(await myPromise);

            userTechnicalOption();
        }

        addUserToTable();
    }

    function addUserTechnicalGroup() {
        let name = $('#search_user_group').val();

        async function addUserGroupToTable() {
            let myPromise = new Promise(function(myResolve, myReject) {  
                $.ajax({
                    type: 'POST', 
                    url: '/api/user-technical-group',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "name": name,
                    },
                    async: false,
                    success: function (data) {
                        console.log(data);
                        if (data.data != null) {
                            var index = id_user_technical_groups.indexOf(parseInt(data.data.id));
                            if (index !== -1) {
                                $.alert("User Group has been added");
                            } else {
                                id_user_technical_groups.push(data.data.id);
                                var btn = `<button type="button" onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                                var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                user_technical_group_table.row.add([
                                    data.data.name,  
                                    btn,
                                    action,         
                                ]);

                                user_technical_group_table.draw();
                            }
                        } else {
                            $.confirm({
                                title: 'User Group Not Found!',
                                content: 'Do you want to create a new user group?',
                                buttons: {
                                    yes: function () {
                                        $.confirm({
                                            title: 'Create User Group',
                                            content: 'URL:/user-technical-groups/create-modal',
                                            columnClass: 'medium',
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Submit',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        let name, description, tasks;
                                                        name = this.$content.find('#name').val();
                                                        description = this.$content.find('#description').val();
                                                        users_technicals = this.$content.find('#e1').val();

                                                        $.ajax({
                                                            type: 'POST', 
                                                            url: '/user-technical-groups',
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            data: {
                                                                "_token": "{{ csrf_token() }}",
                                                                "name": name,
                                                                "description": description,
                                                                "user_technicals": users_technicals,
                                                                "from": 'work_order'
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                if (data.status == 200) {
                                                                    var index = id_user_technical_groups.indexOf(parseInt(data.data.id));
                                                                    if (index !== -1) {
                                                                        $.alert("User Group has been added");
                                                                    } else {
                                                                        id_user_technical_groups.push(data.data.id);
                                                                        userTechnicalGroupOption();
                                                                        var btn = `<button onclick="detailModal('Detail User Technical', '/user-technical-groups/' + ${data.data.id}, 'xl')" class="btn btn-md btn-primary"><i class="ion ion-eye"></i> Show</button>`;
                                                                        var action = `<button type="button" onclick="deleteUserGroup('${data.data.id}')" class="btn btn-md btn-danger"><i class="fas fa-times"></i></button>`;
                                                                        user_technical_group_table.row.add([
                                                                            data.data.name,  
                                                                            btn,
                                                                            action,              
                                                                        ]);

                                                                        user_technical_group_table.draw();
                                                                    }
                                                                } else {
                                                                    let msg = data.msg;
                                                                    $.alert(msg);
                                                                    return false;
                                                                }
                                                            },
                                                            error: function (data) {
                                                                $.alert(data.responseJSON.message);
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
                                    },
                                    no: function () {
                                        
                                    },
                            }
                        });
                        }
                    },
                    error: function (data) {
                        $.alert(data.responseJSON.message);
                        console.log(data);
                    }
                });
               
                myResolve('i Love You 3000')
            });

            console.log(await myPromise);

            userTechnicalGroupOption();
        }

        addUserGroupToTable();
    }

    function chooseReferenceDocuments() {
        $('.referenceId').remove()
        reference_document_table.rows().remove().draw();
        const assetId = $('select[name="asset_id"]').val() ?? 0;
        console.log(assetId);
        $.confirm({
            title: 'Choose reference documents',
            content: 'URL:/api/reference-documents/' + assetId,
            columnClass: 'large',
            buttons: {
                okay: {
                    text: 'Okay',
                    btnClass: 'btn-blue',
                    action: function () {
                        var rows_selected = window.table.column(0).checkboxes.selected();
                        console.log(window.table.column(0));
                        $.each(rows_selected, function(index, id){
                            $('#form').append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('class', 'referenceId')
                                    .attr('name', 'referenceId[]')
                                    .val(id)
                            );
                            
                            $.ajax({
                                type: 'POST', 
                                url: '/api/reference-document/'+id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    "id": id,
                                },
                                async: false,
                                success: function (data) {
                                    console.log(data);
                                    // id_user_technical_groups.push(data.data.id);
                                    reference_document_table.row.add([
                                       data.data.filename.slice(0, 45) + (data.data.filename.length > 45 ? "..." : ""),        
                                    ]);

                                    reference_document_table.draw();
                                },
                                error: function (data) {
                                    $.alert(data.responseJSON.message);
                                    console.log(data);
                                }
                            });
                        });
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                table = $('#table1').DataTable({     
                    'columnDefs': [
                        {
                            'targets': 0,
                            'checkboxes': {
                                'selectRow': true
                            }
                        }
                    ],
                    'select': {
                        'style': 'multi',
                    },
                    'searching': false,
                    "paging":   false,
                    "ordering": false,
                    "info":     false
                });
            }
        });
    }

    function oldValueReferenceDocuments() {
        let inputs = $('.referenceId');
        let referenceIds  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        $.each(referenceIds, function(index, id){
            $.ajax({
                type: 'POST', 
                url: '/api/reference-document/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "id": id,
                },
                async: false,
                success: function (data) {
                    console.log(data);
                    reference_document_table.row.add([
                        data.data.filename.slice(0, 45) + (data.data.filename.length > 45 ? "..." : ""),        
                    ]);

                    reference_document_table.draw();
                },
                error: function (data) {
                    $.alert(data.responseJSON.message);
                    console.log(data);
                }
            });
        });
    }

    async function deleteUser(id) {
        $('.user_technicals').remove()
        var index = id_user_technicals.indexOf(parseInt(id));
        var ids = [];
        console.log(id_user_technicals);
        let myPromise = new Promise(function(myResolve, myReject) {
            if (index !== -1) {
                console.log("delete " + index);
                id_user_technicals.splice(index, 1);
                ids = id_user_technicals;
                console.log(id_user_technicals);
            }        

            user_technical_table.rows().remove().draw();

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        if (ids.length > 0) {
            id_user_technicals = [];
            oldUserTechnicals(ids);
        } else {
            userTechnicalOption()
        }
    }

    async function deleteUserGroup(id) {
        $('.user_technical_groups').remove()
        var index = id_user_technical_groups.indexOf(parseInt(id));
        var ids = [];
        let myPromise = new Promise(function(myResolve, myReject) {
            if (index !== -1) {
                id_user_technical_groups.splice(index, 1);
                ids = id_user_technical_groups;
            }        

            user_technical_group_table.rows().remove().draw();

            myResolve('i Love You 3000')
        });

        console.log(await myPromise);

        if (ids.length > 0) {
            id_user_technical_groups = [];
            oldUserTechnicalGroups(ids);
        } else {
            userTechnicalGroupOption()
        }
    }
</script>
@endsection