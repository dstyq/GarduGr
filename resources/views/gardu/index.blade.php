@extends('layouts.app')

@section('breadcumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $breadcumb ?? 'Gardu' }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $breadcumb ?? 'Gardu' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <h1>Data Gardu</h1>
    <p>Welcome to the Gardu management page!</p>

    <div class="mb-3">
        <a href="{{ route('gardu.create') }}" class="btn btn-primary">Add New Gardu</a>
    </div>

    <!-- Search Form -->
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
                    <th>No</th>
                    <th>Nama Gardu Induk</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gardus as $index => $gardu)
                    <tr>
                        <td>{{ $gardu->gardu_induk }}</td>
                        <td>
                            <a href="{{ route('gardu.edit', $gardu->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('gardu.destroy', $gardu->id) }}" method="POST" style="display:inline;">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                            </form>
                            <button class="btn btn-info" onclick="toggleForm('form-{{ $gardu->id }}')">View Form</button>
                        </td>
                    </tr>
                    @include('gardu.form', ['gardu' => $gardu])
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
function toggleForm(formId) {
    var form = document.getElementById(formId);
    form.style.display = form.style.display === "none" ? "table-row" : "none"; 
}
</script>
@endsection
