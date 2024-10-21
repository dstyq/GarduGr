@extends('layouts.app')

@section('content')
    <h1>Edit Gardu</h1>
    <form action="{{ route('gardu.update', $gardu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Gardu</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $gardu->nama }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('gardu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection