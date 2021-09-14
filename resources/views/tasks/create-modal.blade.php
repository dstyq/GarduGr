<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <div class="card-body">

        @include('components.form-message')

        <div class="form-group">
            <label for="task">Task</label>
            <input type="text" class="form-control @error('task') is-invalid @enderror" id="task" name="task" value="{{ old('task') }}" placeholder="Enter task">

            @error('task')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="time_estimate">Time Estimate <small>(minutes)</small></label>
            <input type="number" class="form-control @error('time_estimate') is-invalid @enderror" id="time_estimate" name="time_estimate" value="{{ old('time_estimate') }}" placeholder="Enter time estimate">

            @error('time_estimate')
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
    </div>
</form>