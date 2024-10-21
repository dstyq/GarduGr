@extends('layouts.app')

@section('content')
    <h1>Tambah Gardu</h1>
    <form action="{{ route('gardu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Gardu</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('gardu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection