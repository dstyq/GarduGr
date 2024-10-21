@extends('layouts.app')

@section('content')
    <h1>Data Gardu</h1>
    <a href="{{ route('gardu.create') }}" class="btn btn-primary">Tambah Gardu</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Gardu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gardus as $gardu)
                <tr>
                    <td>{{ $gardu->id }}</td>
                    <td>{{ $gardu->nama }}</td>
                    <td>
                        <a href="{{ route('gardu.edit', $gardu->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('gardu.destroy', $gardu->id) }}" method="POST" style="display:inline;">
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