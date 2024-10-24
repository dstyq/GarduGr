@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Data Gardu</h1>
    <a href="{{ route('gardu.create') }}" class="btn btn-primary mb-3">Tambah Gardu</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Gardu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($gardus->isEmpty())
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data gardu.</td>
                </tr>
            @else
                @foreach ($gardus as $gardu)
                    <tr>
                        <td>{{ $gardu->id }}</td>
                        <td>{{ $gardu->nama }}</td>
                        <td>
                            <a href="{{ route('gardu.edit', $gardu->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('gardu.destroy', $gardu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gardu ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
