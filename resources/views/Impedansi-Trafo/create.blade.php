@extends('layouts.app')

@section('content')
    <h1>Tambah Impedansi Trafo</h1>
    <form action="{{ route('impedansi_trafo.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_trafo">Nama Trafo</label>
            <input type="text" name="nama_trafo" id="nama_trafo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="impedansi">Impedansi</label>
            <input type="text" name="impedansi" id="impedansi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('impedansi_trafo.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection