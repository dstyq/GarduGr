<form method="POST" action="{{ route('user-technical-groups.store') }}" novalidate>
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
            <label for="">User Technicals</label> <br>
            <small>Select All</small>
            <input type="checkbox" id="checkbox">

            <div class="select2-purple">
                <select class="select-user-group" name="user_technicals[]" id="e1" data-placeholder="Select User Technical" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                    @foreach ($user_technicals as $user_technical)
                        <option value="{{$user_technical->id}}" 
                            @foreach (old('user_technicals') ?? [] as $id)
                                @if ($id == $user_technical->id)
                                    {{ ' selected' }}
                                @endif
                            @endforeach>
                            {{$user_technical->username}}
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
<script>
    $(function () {
        bsCustomFileInput.init();
        //Initialize Select2 Elements
        $('.select-user-group').select2({
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