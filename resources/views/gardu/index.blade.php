@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Gardu</h1>
    <p>Welcome to the Gardu management page!</p>

    <div class="mb-3">
        <a href="{{ route('gardu.create') }}" class="btn btn-primary">Add New Gardu</a>
    </div>

    <!-- Filter Pencarian (Opsional) -->
    <form method="GET" action="{{ route('impedansi-trafo.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Gardu Name" value="{{ request()->get('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>
    
    @if($gardus->isEmpty())
        <div class="alert alert-warning" role="alert">
            No Gardu records found.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Gardu Induk</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gardus as $gardu)
                    <tr>
                        <td>{{ $gardu->id }}</td>
                        <td>{{ $gardu->gardu_induk }}</td>
                        <td>
                            <a href="{{ route('gardu.edit', $gardu->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('gardu.destroy', $gardu->id) }}" method="POST" style="display:inline;">
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
