@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Gardu</h1>
    <form action="{{ route('gardu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="gardu_induk">Nama Gardu Induk</label>
            <input type="text" name="gardu_induk" id="gardu_induk" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('gardu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
