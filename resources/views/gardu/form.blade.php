<tr id="form-{{ $gardu->id }}" style="display: none;">
    <td colspan="3">
        <form action="{{ route('impedansi-trafo.store') }}" method="POST" class="mb-3">
            @csrf
            <input type="hidden" name="id_gardu" value="{{ $gardu->id }}">

            <!-- Hubung Singkat Sistem Transmisi -->
            <h5 class="mt-4">HUBUNG SINGKAT SISTEM TRANSMISI</h5>
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

            <!-- Impedansi Trafo Tenaga dari Data Name Plate Trafo -->
            <h5 class="mt-4">IMPEDANSI TRAFO TENAGA DARI DATA NAME PLATE TRAFO</h5>
            <div class="form-group">
                <label for="kapasitas_{{ $gardu->id }}">Kapasitas (MVA)</label>
                <input type="number" step="0.01" name="kapasitas" class="form-control" id="kapasitas_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="impedansi_trafo_{{ $gardu->id }}">Impedansi Trafo (%)</label>
                <input type="number" step="0.01" name="impedansi_trafo" class="form-control" id="impedansi_trafo_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_primer_{{ $gardu->id }}">Volt Primer (kV)</label>
                <input type="number" step="0.01" name="volt_primer" class="form-control" id="volt_primer_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_sekunder_2_{{ $gardu->id }}">Volt Sekunder (kV)</label>
                <input type="number" step="0.01" name="volt_sekunder_2" class="form-control" id="volt_sekunder_2_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="belitan_delta">Belitan Delta</label>
                <input type="text" name="belitan_delta" class="form-control">
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

            <!-- Ratio C T 20kV -->
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

            <!-- XT Calculations -->
            <div class="form-group">
                <label for="xt_1_{{ $gardu->id }}">XT 1 (Ohm)</label>
                <input type="number" step="0.01" name="xt_1" class="form-control" id="xt_1_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" onclick="calculateXT1({{ $gardu->id }})">Calculate XT 1</button>

            <div class="form-group">
                <label for="xt_0_{{ $gardu->id }}">XT 0 (Ohm)</label>
                <input type="number" step="0.01" name="xt_0" class="form-control" id="xt_0_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" onclick="calculateXT0({{ $gardu->id }})">Calculate XT 0</button>

            <!-- XLPE-AL Cable -->
            <div class="form-group">
                <label for="xlpe_al_cable_{{ $gardu->id }}">XLPE-AL Cable (mH/km)</label>
                <input type="number" step="0.01" name="inductance_per_km" class="form-control" id="xlpe_al_cable_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="xlpe_al_cable_output_{{ $gardu->id }}">XLPE-AL Cable (ωL)</label>
                <input type="number" step="0.01" name="xlpe_al_cable" class="form-control" id="xlpe_al_cable_output_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" onclick="calculateXLPEALCable({{ $gardu->id }})">Calculate XLPE-AL Cable</button>

            <!-- Impedansi Penyulang 20kV -->
            <h5 class="mt-4">IMPEDANSI PENYULANG 20kV</h5>
            <p>Data impedansi jaringan/km</p>

            <div class="form-group">
                <label for="z1_km_{{ $gardu->id }}">Z1/km</label>
                <input type="number" step="0.01" name="z1_km" class="form-control" id="z1_km_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="z1_km_output_{{ $gardu->id }}"></label>
                <input type="number" step="0.01" name="z1_km_output" class="form-control" id="z1_km_output_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" onclick="calculateZ1Km({{ $gardu->id }})">Calculate Z1/km</button>

            <div class="form-group">
                <label>Z0/km</label>
                <div>
                    <input type="number" step="0.01" name="z0_km_1" class="form-control" id="z0_km_{{ $gardu->id }}_1" required readonly>
                </div>
                <div>
                    <input type="number" step="0.01" name="z0_km_2" class="form-control" id="z0_km_{{ $gardu->id }}_2" required readonly>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="calculateZ0Km({{ $gardu->id }})">Calculate Z0/km</button>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="">Seksi GI-GH1</label>
                    <input type="number" step="0.01" name="seksi_gi_gh1" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="">Seksi G1-ujung</label>
                    <input type="number" step="0.01" name="seksi_g1_ujung" class="form-control" required>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center" style="text-align: left; padding-left: 20px;">Z1 Jar</th>
                        <th colspan="2" class="text-center" style="text-align: left; padding-left: 50px;">Z0 Jar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>RI1</td>
                        <td><input type="text" class="form-control" name="ri1_z1" required readonly></td>
                        <td>RI1</td>
                        <td><input type="text" class="form-control" name="ri1_z0" required readonly></td>
                    </tr>
                    <tr>
                        <td>j XI1</td>
                        <td><input type="text" class="form-control" name="j_xi1_z1" required readonly></td>
                        <td>j XI1</td>
                        <td><input type="text" class="form-control" name="j_xi1_z0" required readonly></td>
                    </tr>
                    <tr>
                        <td>RI2</td>
                        <td><input type="text" class="form-control" name="ri2_z1" required readonly></td>
                        <td>RI2</td>
                        <td><input type="text" class="form-control" name="ri2_z0" required readonly></td>
                    </tr>
                    <tr>
                        <td>j XI2</td>
                        <td><input type="text" class="form-control" name="j_xi2_z1" required readonly></td>
                        <td>j XI2</td>
                        <td><input type="text" class="form-control" name="j_xi2_z0" required readonly></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            <button type="button" class="btn btn-primary" onclick="calculateAll({{ $gardu->id }})">Calculate All</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Sumary Impedansi -->
            <h5 class="mt-4">SUMARY IMPEDANSI</h5>

            <!-- Impedansi Ukuran Positif -->
            <h5 class="mt-4">IMPEDANSI URUTAN POSITIF </h5>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mt-3">Add Impedansi Trafo</button>
        </form>
    </td>
</tr>

<script>
    // Function to calculate impedansi sumber 
    function calculateImpedance(garduId) {
        const mvaShortCircuit = parseFloat(document.getElementById('mva_short_circuit_' + garduId).value) || 0;
        const voltSekunder = parseFloat(document.getElementById('volt_sekunder_' + garduId).value) || 0;
        if (mvaShortCircuit > 0 && voltSekunder > 0) {
            const impedanceSumber = (voltSekunder ** 2) / mvaShortCircuit;
            document.getElementById('impedansi_sumber_' + garduId).value = impedanceSumber.toFixed(9);
        } else {
            alert('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
        }
    }

    // Function to calculate kapasitas delta
    function calculateKapasitasDelta(garduId) {
        const kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;
        const kapasitasDelta = kapasitas / 3;
        document.getElementById('kapasitas_delta_' + garduId).value = kapasitasDelta.toFixed(2);
    }

    // Function to calculate I Nominal
    function calculateINominal(garduId) {
        const kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;
        const voltSekunder = parseFloat(document.getElementById('volt_sekunder_2_' + garduId).value) || 0;
        if (voltSekunder > 0) {
            const iNominal = (kapasitas * 1000) / (voltSekunder * Math.sqrt(3));
            document.getElementById('i_nominal_20kv_' + garduId).value = iNominal.toFixed(6);
        } else {
            alert('Please enter a valid value for Volt Sekunder to calculate I Nominal.');
        }
    }

    // Function to calculate XT1
    function calculateXT1(garduId) {
        const impedansiTrafo = parseFloat(document.getElementById('impedansi_trafo_' + garduId).value) || 0;
        const voltSekunder = parseFloat(document.getElementById('volt_sekunder_2_' + garduId).value) || 0;
        const kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;

        if (impedansiTrafo > 0 && voltSekunder > 0 && kapasitas > 0) {
            const xt1 = (impedansiTrafo / 100) * (voltSekunder ** 2) / kapasitas;
            document.getElementById('xt_1_' + garduId).value = xt1.toFixed(9);
        } else {
            alert('Please enter valid values for Impedansi Trafo, Volt Sekunder, and Kapasitas to calculate XT 1.');
        }
    }

    // Function to calculate XT0
    function calculateXT0(garduId) {
        const belitanDelta = document.querySelector('input[name="belitan_delta"]').value.trim();
        const xt1 = parseFloat(document.getElementById('xt_1_' + garduId).value) || 0;
        const kapasitas = parseFloat(document.getElementById('kapasitas_' + garduId).value) || 0;
        const kapasitasDelta = parseFloat(document.getElementById('kapasitas_delta_' + garduId).value) || 0;

        let xt0;
        if (belitanDelta) {
            xt0 = (kapasitas / kapasitasDelta) * xt1;
        } else {
            xt0 = xt1 * 10;
        }
        document.getElementById('xt_0_' + garduId).value = xt0.toFixed(9);
    }

    // Function to calculate XLPE-AL Cable
    function calculateXLPEALCable(garduId) {
        const inductance = parseFloat(document.getElementById('xlpe_al_cable_' + garduId).value) || 0;
        const PI = Math.PI;

        if (inductance > 0) {
            const xlpeALCable = (2 * PI * 50 * inductance) / 1000;
            document.getElementById('xlpe_al_cable_output_' + garduId).value = xlpeALCable.toFixed(9);
        } else {
            alert('Please enter a valid value for Inductance.');
        }
    }

    // Function to calculate Z1/km
    function calculateZ1Km(garduId) {
        const xlpeALCableOutput = parseFloat(document.getElementById('xlpe_al_cable_output_' + garduId).value) || 0;
        document.getElementById('z1_km_output_' + garduId).value = xlpeALCableOutput.toFixed(9);
    }

    // Function to calculate Z0/km
    function calculateZ0Km(garduId) {
        const z1Km = parseFloat(document.getElementById('z1_km_' + garduId).value) || 0;
        const z1KmOutput = parseFloat(document.getElementById('z1_km_output_' + garduId).value) || 0;

        const z0Km1 = 2.2 * z1Km;
        const z0Km2 = 3 * z1KmOutput;

        document.getElementById('z0_km_' + garduId + '_1').value = z0Km1.toFixed(3);
        document.getElementById('z0_km_' + garduId + '_2').value = z0Km2.toFixed(9);
    }

    // Function to calculate all Z1 and Z0 
    function calculateAll(garduId) {
        // Calculate Z1 Jar with RI1
        const z1Km = parseFloat(document.getElementById('z1_km_' + garduId).value) || 0;
        const seksiGIGH1 = parseFloat(document.getElementById('seksi_gi_gh1').value) || 0;
        if (z1Km > 0 && seksiGIGH1 > 0) {
            const ri1 = z1Km * seksiGIGH1;
            document.getElementsByName('ri1_z1')[0].value = ri1.toFixed(3);
        } else {
            alert('Please enter valid values for Z1/km and Seksi GI-GH1.');
            return;
        }

        // Calculate Z1 Jar with j Xl1
        const z1KmOutput = parseFloat(document.getElementById('z1_km_output_' + garduId).value) || 0;
        if (z1KmOutput > 0 && seksiGIGH1 > 0) {
            const jXi1 = z1KmOutput * seksiGIGH1;
            document.getElementsByName('j_xi1_z1')[0].value = jXi1.toFixed(3);
        } else {
            alert('Please enter valid values for Z1/km Output and Seksi GI-GH1.');
            return;
        }

        // Calculate Z1 Jar with RI2
        const seksiG1Ujung = parseFloat(document.getElementById('seksi_g1_ujung').value) || 0;
        if (z1Km > 0 && seksiG1Ujung > 0) {
            const ri2 = z1Km * seksiG1Ujung;
            document.getElementsByName('ri2_z1')[0].value = ri2.toFixed(3);
        } else {
            alert('Please enter valid values for Z1/km and Seksi G1-ujung.');
            return;
        }

        // Calculate Z1 Jar with j Xl2
        if (z1KmOutput > 0 && seksiG1Ujung > 0) {
            const jXi2 = z1KmOutput * seksiG1Ujung;
            document.getElementsByName('j_xi2_z1')[0].value = jXi2.toFixed(3);
        } else {
            alert('Please enter valid values for Z1/km Output and Seksi G1-ujung.');
            return;
        }

        // Calculate Z0 Jar with RI1
        const z0Km1 = parseFloat(document.getElementById('z0_km_' + garduId + '_1').value) || 0;
        if (seksiGIGH1 > 0 && z0Km1 > 0) {
            const ri1Z0 = seksiGIGH1 * z0Km1;
            document.getElementsByName('ri1_z0')[0].value = ri1Z0.toFixed(3);
        } else {
            alert('Please enter valid values for Seksi GI-GH1 and Z0/km 1.');
            return;
        }

        // Calculate Z0 Jar with j Xl1
        const z0Km2 = parseFloat(document.getElementById('z0_km_' + garduId + '_2').value) || 0;
        if (seksiGIGH1 > 0 && z0Km2 > 0) {
            const jXi1Z0 = seksiGIGH1 * z0Km2;
            document.getElementsByName('j_xi1_z0')[0].value = jXi1Z0.toFixed(3);
        } else {
            alert('Please enter valid values for Seksi GI-GH1 and Z0/km 2.');
            return;
        }

        // Calculate Z0 Jar with RI2
        if (seksiG1Ujung > 0 && z0Km1 > 0) {
            const ri2Z0 = z0Km1 * seksiG1Ujung;
            document.getElementsByName('ri2_z0')[0].value = ri2Z0.toFixed(3);
        } else {
            alert('Please enter valid values for Seksi G1-ujung and Z0/km 1.');
            return;
        }

        // Calculate Z0 Jar with j Xl2
        if (seksiG1Ujung > 0 && z0Km2 > 0) {
            const jXi2Z0 = z0Km2 * seksiG1Ujung;
            document.getElementsByName('j_xi2_z0')[0].value = jXi2Z0.toFixed(3);
        } else {
            alert('Please enter valid values for Seksi G1-ujung and Z0/km 2.');
            return;
        }
    }
</script>