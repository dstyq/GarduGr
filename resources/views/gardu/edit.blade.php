@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gardu</h1>
    
    <form action="{{ route('gardu.update', $gardu->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="gardu_induk">Nama Gardu Induk</label>
            <input type="text" name="gardu_induk" id="gardu_induk" class="form-control" value="{{ old('gardu_induk', $gardu->gardu_induk) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('gardu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
