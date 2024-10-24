@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Impedansi Trafo</h1>
    <p>Welcome to the Impedansi Trafo management page!</p>

    <div class="mb-3">
        <a href="{{ route('impedansi-trafo.create') }}" class="btn btn-primary">Add New Impedansi Trafo</a>
    </div>

    @if($impedansiTrafo->isEmpty())
        <div class="alert alert-warning" role="alert">
            No Impedansi Trafo records found.
        </div>
    @else
        <table class="table table-bordered">
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
                        <td>{{ number_format($item->mva_short_circuit, 2) }}</td>
                        <td>{{ number_format($item->mva_di_busbar, 2) }}</td>
                        <td>{{ number_format($item->kapasitas, 2) }}</td>
                        <td>
                            <a href="{{ route('impedansi-trafo.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('impedansi-trafo.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
