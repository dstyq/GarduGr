<head>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
</head>

<form method="POST" action="{{ route('task-groups.store') }}" novalidate>
    @csrf
    <div class="card-body">

        @include('components.form-message')

        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') }}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Description <small>(Optional)</small></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="3" placeholder="Enter description">{{old('description')}}</textarea>

            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Tasks</label> <br>
            <small>Select All</small>
            <input type="checkbox" id="checkbox">

            <div class="select2-purple">
                <select class="select-task" name="tasks[]" id="e1" data-placeholder="Select The Task" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                    @foreach ($tasks as $task)
                        <option value="{{$task->id}}" 
                            @foreach (old('tasks') ?? [] as $id)
                                @if ($id == $task->id)
                                    {{ ' selected' }}
                                @endif
                            @endforeach>
                            {{$task->task}}
                        </option>
                    @endforeach
                </select>
            </div>

            @error('tasks')
                <span class="text-danger text-sm">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</form>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
        //Initialize Select2 Elements
        $('.select-task').select2({
            dropdownParent: $('.jconfirm-box')
        });
    })

    $("#checkbox").click(function () {
       if ($("#checkbox").is(':checked')) {
           $("#e1 > option").prop("selected", "selected");
           $("#e1").trigger("change");
       } else {
           $("#e1 > option").removeAttr("selected");
           $("#e1").val("");
           $("#e1").trigger("change");
       }
   });
</script>