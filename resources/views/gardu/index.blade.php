@extends('layouts.app')

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
                        <td>{{ $index + 1 }}</td>
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
                    <tr id="form-{{ $gardu->id }}" style="display: none;">
                        <td colspan="3">
                            <!-- Form for Impedansi Trafo -->
                            <form action="{{ route('impedansi-trafo.store') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="id_gardu" value="{{ $gardu->id }}">
                                
                                <div class="form-group">
                                    <label>MVA Short Circuit</label>
                                    <input type="number" step="0.01" name="mva_short_circuit" class="form-control" id="mva_short_circuit_{{ $gardu->id }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Volt Sekunder</label>
                                    <input type="number" step="0.01" name="volt_sekunder" class="form-control" id="volt_sekunder_{{ $gardu->id }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Impedansi Sumber (Ohm)</label>
                                    <input type="number" step="0.01" name="impedansi_sumber" class="form-control" id="impedansi_sumber_{{ $gardu->id }}" required readonly>
                                </div>

                                <button type="button" class="btn btn-secondary" onclick="calculateImpedance({{ $gardu->id }})">Calculate</button>

                                <div class="form-group">
                                    <label>MVA di Busbar</label>
                                    <input type="number" step="0.01" name="mva_di_busbar" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Kapasitas</label>
                                    <input type="number" step="0.01" name="kapasitas" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Impedansi Trafo</label>
                                    <input type="number" step="0.01" name="impedansi_trafo" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Volt Primer</label>
                                    <input type="number" step="0.01" name="volt_primer" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Belitan Delta</label>
                                    <input type="text" name="belitan_delta" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Kapasitas Delta</label>
                                    <input type="number" step="0.01" name="kapasitas_delta" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Ratio C T 20kV 1</label>
                                    <input type="number" step="0.01" name="ratio_c_t_20kv_1" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Ratio C T 20kV 2</label>
                                    <input type="number" step="0.01" name="ratio_c_t_20kv_2" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Pentahanan Netral</label>
                                    <input type="number" step="0.01" name="pentahanan_netral" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>XT 1</label>
                                    <input type="number" step="0.01" name="xt_1" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>I Nominal 20kV</label>
                                    <input type="number" step="0.01" name="i_nominal_20kv" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-success">Add Impedansi Trafo</button>
                            </form>
                        </td>
                    </tr>
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

function calculateImpedance(garduId) {
    var mvaShortCircuit = parseFloat(document.getElementById('mva_short_circuit_' + garduId).value) || 0;
    var voltSekunder = parseFloat(document.getElementById('volt_sekunder_' + garduId).value) || 0;

    if (mvaShortCircuit > 0 && voltSekunder > 0) {
        var impedanceSumber = (voltSekunder * voltSekunder) / mvaShortCircuit;
        document.getElementById('impedansi_sumber_' + garduId).value = impedanceSumber.toFixed(9); 
    } else {
        alert('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
    }
}
</script>
@endsection