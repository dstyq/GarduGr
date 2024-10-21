@extends('layouts.app')

@section('content')
    <h1>Data Impedansi Trafo</h1>
    <a href="{{ route('impedansi_trafo.create') }}" class="btn btn-primary">Tambah Impedansi Trafo</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Trafo</th>
                <th>Impedansi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($impedansiTrafo as $trafo)
                <tr>
                    <td>{{ $trafo->id }}</td>
                    <td>{{ $trafo->nama_trafo }}</td>
                    <td>{{ $trafo->impedansi }}</td>
                    <td>
                        <a href="{{ route('impedansi_trafo.edit', $trafo->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('impedansi_trafo.destroy', $trafo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection