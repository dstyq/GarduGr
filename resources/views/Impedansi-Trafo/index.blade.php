@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Impedansi Trafo</h1>
    <p>Welcome to the Impedansi Trafo management page!</p>

    <div class="mb-3">
        <a href="{{ route('impedansi-trafo.create') }}" class="btn btn-primary">Add New Impedansi Trafo</a>
    </div>

    @if($impedansiTrafo->isEmpty())
        <p>No Impedansi Trafo records found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Gardu</th>
                    <th>MVA Short Circuit</th>
                    <th>MVA Di Busbar</th>
                    <th>Kapasitas</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($impedansiTrafo as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->id_gardu }}</td>
                        <td>{{ $item->mva_short_circuit }}</td>
                        <td>{{ $item->mva_di_busbar }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>
                            <a href="{{ route('impedansi-trafo.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('impedansi-trafo.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
