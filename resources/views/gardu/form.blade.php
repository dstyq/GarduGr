<tr id="form-{{ $gardu->id }}" style="display: none;">
    <td colspan="3">
        <form action="{{ route('impedansi-trafo.store') }}" method="POST" class="mb-3">
            @csrf
            <input type="hidden" name="id_gardu" value="{{ $gardu->id }}">

            <div class="form-group">
                <label for="mva_short_circuit_{{ $gardu->id }}">MVA Short Circuit (MVA)</label>
                <input type="number" step="0.01" name="mva_short_circuit" class="form-control" id="mva_short_circuit_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_sekunder_{{ $gardu->id }}">Volt Sekunder (kV)</label>
                <input type="number" step="0.01" name="volt_sekunder" class="form-control" id="volt_sekunder_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="impedansi_sumber_{{ $gardu->id }}">Impedansi Sumber (Ohm)</label>
                <input type="number" step="0.01" name="impedansi_sumber" class="form-control" id="impedansi_sumber_{{ $gardu->id }}" required readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="calculateImpedance({{ $gardu->id }})">Calculate Impedansi Sumber</button>

            <div class="form-group">
                <label for="kapasitas_{{ $gardu->id }}">Kapasitas (MVA)</label>
                <input type="number" step="0.01" name="kapasitas" class="form-control" id="kapasitas_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="impedansi_trafo">Impedansi Trafo (%)</label>
                <input type="number" step="0.01" name="impedansi_trafo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="volt_primer">Volt Primer (kV)</label>
                <input type="number" step="0.01" name="volt_primer" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="belitan_delta">Belitan Delta</label>
                <input type="text" name="belitan_delta" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kapasitas_delta_{{ $gardu->id }}">Kapasitas Delta (MVA)</label>
                <input type="number" step="0.01" name="kapasitas_delta" class="form-control" id="kapasitas_delta_{{ $gardu->id }}" required readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="calculateKapasitasDelta({{ $gardu->id }})">Calculate Kapasitas Delta</button>

            <div class="form-group">
                <label for="i_nominal_20kv_{{ $gardu->id }}">I Nominal 20kV (Ampere)</label>
                <input type="number" step="0.01" name="i_nominal_20kv" class="form-control" id="i_nominal_20kv_{{ $gardu->id }}" required readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="calculateINominal({{ $gardu->id }})">Calculate I Nominal 20kV</button>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="ratio_c_t_20kv_1">Ratio C T 20kV 1</label>
                    <input type="number" step="0.01" name="ratio_c_t_20kv_1" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="ratio_c_t_20kv_2">Ratio C T 20kV 2</label>
                    <input type="number" step="0.01" name="ratio_c_t_20kv_2" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="pentahanan_netral">Pentahanan Netral (Ohm)</label>
                <input type="number" step="0.01" name="pentahanan_netral" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="xt_1_{{ $gardu->id }}">XT 1 (Ohm)</label>
                <input type="number" step="0.01" name="xt_1" class="form-control" id="xt_1_{{ $gardu->id }}" required readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="calculateXT1({{ $gardu->id }})">Calculate XT 1</button>

            <div class="form-group">
                <label for="xt_2_{{ $gardu->id }}">XT 2 (Ohm)</label>
                <input type="number" step="0.01" name="xt_2" class="form-control" id="xt_2_{{ $gardu->id }}" required readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="calculateXT2({{ $gardu->id }})">Calculate XT 2</button>

            <button type="submit" class="btn btn-success">Add Impedansi Trafo</button>
        </form>
    </td>
</tr>

<script>
function calculateImpedance(garduId) {
    var mvaShortCircuit = parseFloat(document.getElementById('mva_short_circuit_' + garduId).value) || 0;
    var voltSekunder = parseFloat(document.getElementById('volt_sekunder_' + garduId).value) || 0;

    if (mvaShortCircuit > 0 && voltSekunder > 0) {
        // Calculate Impedance Sumber
        var impedanceSumber = (voltSekunder ** 2) / mvaShortCircuit;
        document.getElementById('impedansi_sumber_' + garduId).value = impedanceSumber.toFixed(9); 
    } else {
        alert('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
    }
}

function calculateKapasitasDelta(garduId) {
    var kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;

    // Calculate Kapasitas Delta
    var kapasitasDelta = kapasitas / 3;
    document.getElementById('kapasitas_delta_' + garduId).value = kapasitasDelta.toFixed(0); 
}

function calculateINominal(garduId) {
    var kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;
    var voltSekunder = parseFloat(document.getElementById('volt_sekunder_' + garduId).value) || 0;

    // Calculate I Nominal 20kV
    if (voltSekunder > 0) {
        var iNominal = (kapasitas * 1000) / (voltSekunder * Math.sqrt(3));
        document.getElementById('i_nominal_20kv_' + garduId).value = iNominal.toFixed(6);
    } else {
        alert('Please enter a valid value for Volt Sekunder to calculate I Nominal.');
    }
}

</script>
