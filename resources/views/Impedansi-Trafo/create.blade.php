@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Impedansi Trafo</h1>
    <form action="{{ route('impedansi-trafo.store') }}" method="POST">
        @csrf
        <!-- Add your input fields here -->
        <div class="form-group">
            <label>ID Gardu</label>
            <input type="text" name="id_gardu" class="form-control" required>
        </div>
        <!-- Add other fields similarly -->
        <button type="submit" class="btn btn-success">Add Impedansi Trafo</button>
    </form>
</div>
@endsection
