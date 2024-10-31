@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Impedansi Trafo</h1>
    <p>Welcome to the Impedansi Trafo management page!</p>

    <div class="mb-3">
        <a href="{{ route('impedansi-trafo.create') }}" class="btn btn-primary">Add New Impedansi Trafo</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('impedansi-trafo.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Gardu Name" value="{{ request()->get('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    @if($impedansiTrafo->isEmpty())
        <div class="alert alert-warning" role="alert">
            No Impedansi Trafo records found.
        </div>
    @else
        <div class="table-responsive"> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th> 
                        <th>Nama Gardu</th>
                        <th>MVA Short Circuit</th>
                        <th>MVA Di Busbar</th>
                        <th>Kapasitas</th>
                        <th>Impedansi Trafo</th>
                        <th>Volt Primer</th>
                        <th>Volt Sekunder</th>
                        <th>Belitan Delta</th>
                        <th>Kapasitas Delta</th>
                        <th>Ratio C T 20kV 1</th>
                        <th>Ratio C T 20kV 2</th>
                        <th>Pentahanan Netral</th>
                        <th>XT 1</th>
                        <th>I Nominal 20kV</th>
                        <th>Impedansi Sumber</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($impedansiTrafo as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td> 
                            <td>{{ $item->gardu->gardu_induk ?? 'N/A' }}</td>
                            <td>{{ number_format($item->mva_short_circuit) }}</td>
                            <td>{{ number_format($item->mva_di_busbar) }}</td>
                            <td>{{ number_format($item->kapasitas) }}</td>
                            <td>{{ number_format($item->impedansi_trafo) }}</td>
                            <td>{{ number_format($item->volt_primer) }}</td>
                            <td>{{ number_format($item->volt_sekunder) }}</td>
                            <td>{{ $item->belitan_delta }}</td>
                            <td>{{ number_format($item->kapasitas_delta) }}</td>
                            <td>{{ number_format($item->ratio_c_t_20kv_1) }}</td>
                            <td>{{ number_format($item->ratio_c_t_20kv_2) }}</td>
                            <td>{{ number_format($item->pentahanan_netral) }}</td>
                            <td>{{ number_format($item->xt_1) }}</td>
                            <td>{{ number_format($item->i_nominal_20kv) }}</td>
                            <td>{{ number_format($item->impedansi_sumber) }}</td>
                            <td>
                                <a href="{{ route('impedansi-trafo.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('impedansi-trafo.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr id="form-{{ $item->gardu->id }}" style="display: none;">
                            <td colspan="16">
                                @include('gardu.form', ['gardu' => $item->gardu])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
function toggleForm(garduId) {
    var formRow = document.getElementById('form-' + garduId);
    formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection
