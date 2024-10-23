@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Impedansi Trafo</h1>
    <form action="{{ route('impedansi-trafo.update', $impedansiTrafo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Add your input fields pre-filled with $impedansiTrafo values -->
        <div class="form-group">
            <label>ID Gardu</label>
            <input type="text" name="id_gardu" class="form-control" value="{{ $impedansiTrafo->id_gardu }}" required>
        </div>
        <!-- Add other fields similarly -->
        <button type="submit" class="btn btn-warning">Update Impedansi Trafo</button>
    </form>
</div>
@endsection
