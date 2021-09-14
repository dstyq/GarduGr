@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
<li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('style')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit {{ $task->task }}</h3>
                    </div>

                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @method('patch')
                        @csrf

                        <div class="card-body">

                            @include('components.form-message')
                        
                            <div class="form-group ">
                                <label for="task">Task</label>
                                <input type="text" class="form-control @error('task') is-invalid @enderror" id="task" name="task" value="{{ old('task') ?? $task->task }}" placeholder="Enter task">

                                @error('task')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="time_estimate">Time Estimate <small>(minutes)</small></label>
                                <input type="number" class="form-control @error('time_estimate') is-invalid @enderror" id="time_estimate" name="time_estimate" value="{{ old('time_estimate') ?? $task->time_estimate }}" placeholder="Enter time estimate">

                                @error('time_estimate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="3" placeholder="Enter description">{{old('description') ?? $task->description}}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-footer">Save</button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-footer">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
