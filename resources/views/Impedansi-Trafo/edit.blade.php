@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Impedansi Trafo</h1>
    <form action="{{ route('impedansi-trafo.update', $impedansiTrafo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>ID Gardu</label>
            <select name="id_gardu" class="form-control" required>
                <option value="">Select Gardu</option>
                @foreach($gardu as $g)
                    <option value="{{ $g->id }}" {{ $g->id == $impedansiTrafo->id_gardu ? 'selected' : '' }}>
                        {{ $g->gardu_induk }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>MVA Short Circuit</label>
            <input type="number" step="0.01" name="mva_short_circuit" class="form-control" value="{{ $impedansiTrafo->mva_short_circuit }}" required>
        </div>

        <!--- 
        <div class="form-group">
            <label>MVA di Busbar</label>
            <input type="number" step="0.01" name="mva_di_busbar" class="form-control" value="{{ $impedansiTrafo->mva_di_busbar }}" required>
        </div>
        --->

        <div class="form-group">
            <label>Kapasitas</label>
            <input type="number" step="0.01" name="kapasitas" class="form-control" value="{{ $impedansiTrafo->kapasitas }}" required>
        </div>

        <div class="form-group">
            <label>Impedansi Trafo</label>
            <input type="number" step="0.01" name="impedansi_trafo" class="form-control" value="{{ $impedansiTrafo->impedansi_trafo }}" required>
        </div>

        <div class="form-group">
            <label>Volt Primer</label>
            <input type="number" step="0.01" name="volt_primer" class="form-control" value="{{ $impedansiTrafo->volt_primer }}" required>
        </div>

        <div class="form-group">
            <label>Volt Sekunder</label>
            <input type="number" step="0.01" name="volt_sekunder" class="form-control" value="{{ $impedansiTrafo->volt_sekunder }}" required>
        </div>

        <div class="form-group">
            <label>Belitan Delta</label>
            <input type="text" name="belitan_delta" class="form-control" value="{{ $impedansiTrafo->belitan_delta }}">
        </div>

        <div class="form-group">
            <label>Kapasitas Delta</label>
            <input type="number" step="0.01" name="kapasitas_delta" class="form-control" value="{{ $impedansiTrafo->kapasitas_delta }}" required>
        </div>

        <div class="form-group">
            <label>Ratio C T 20kV 1</label>
            <input type="number" step="0.01" name="ratio_c_t_20kv_1" class="form-control" value="{{ $impedansiTrafo->ratio_c_t_20kv_1 }}">
        </div>

        <div class="form-group">
            <label>Ratio C T 20kV 2</label>
            <input type="number" step="0.01" name="ratio_c_t_20kv_2" class="form-control" value="{{ $impedansiTrafo->ratio_c_t_20kv_2 }}">
        </div>

        <div class="form-group">
            <label>Pentahanan Netral</label>
            <input type="number" step="0.01" name="pentahanan_netral" class="form-control" value="{{ $impedansiTrafo->pentahanan_netral }}">
        </div>

        <div class="form-group">
            <label>XT 1</label>
            <input type="number" step="0.01" name="xt_1" class="form-control" value="{{ $impedansiTrafo->xt_1 }}">
        </div>

        <div class="form-group">
            <label>I Nominal 20kV</label>
            <input type="number" step="0.01" name="i_nominal_20kv" class="form-control" value="{{ $impedansiTrafo->i_nominal_20kv }}">
        </div>

        <div class="form-group">
            <label>Impedansi Sumber</label>
            <input type="number" step="0.01" name="impedansi_sumber" class="form-control" value="{{ $impedansiTrafo->impedansi_sumber }}">
        </div>

        <button type="submit" class="btn btn-success">Update Impedansi Trafo</button>
        <a href="{{ route('impedansi-trafo.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
