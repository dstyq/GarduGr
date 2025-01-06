<tr id="form-{{ $gardu->id }}" style="display: none;">
    <td colspan="3">
        <form action="{{ route('impedansi-trafo.store') }}" method="POST" class="mb-3">
            @csrf
            <input type="hidden" name="id_gardu" value="{{ $gardu->id }}">

            <!-- Hubung Singkat Sistem Transmisi -->
            <h5 class="mt-4">HUBUNG SINGKAT SISTEM TRANSMISI</h5>
            <div class="form-group">
                <label for="mva_short_circuit_{{ $gardu->id }}">MVA Short Circuit (MVA)</label>
                <input type="number" step="0.01" name="mva_short_circuit" class="form-control"
                    id="mva_short_circuit_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_sekunder_{{ $gardu->id }}">Volt Sekunder (kV)</label>
                <input type="number" step="0.01" name="volt_sekunder" class="form-control"
                    id="volt_sekunder_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="impedansi_sumber_{{ $gardu->id }}">Impedansi Sumber (Ohm)</label>
                <input type="number" step="0.01" name="impedansi_sumber" class="form-control"
                    id="impedansi_sumber_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateImpedanceBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate Impedansi Sumber</button>

            <!-- Impedansi Trafo Tenaga dari Data Name Plate Trafo -->
            <h5 class="mt-4">IMPEDANSI TRAFO TENAGA DARI DATA NAME PLATE TRAFO</h5>
            <div class="form-group">
                <label for="kapasitas_{{ $gardu->id }}">Kapasitas (MVA)</label>
                <input type="number" step="0.01" name="kapasitas" class="form-control" id="kapasitas_{{ $gardu->id }}"
                    required>
            </div>

            <div class="form-group">
                <label for="impedansi_trafo_{{ $gardu->id }}">Impedansi Trafo (%)</label>
                <input type="number" step="0.01" name="impedansi_trafo" class="form-control"
                    id="impedansi_trafo_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_primer_{{ $gardu->id }}">Volt Primer (kV)</label>
                <input type="number" step="0.01" name="volt_primer" class="form-control"
                    id="volt_primer_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="volt_sekunder_2_{{ $gardu->id }}">Volt Sekunder (kV)</label>
                <input type="number" step="0.01" name="volt_sekunder_2" class="form-control"
                    id="volt_sekunder_2_{{ $gardu->id }}" required>
            </div>

            <div class="form-group">
                <label for="belitan_delta">Belitan Delta</label><br>

                <input type="radio" name="belitan_delta" value="ada" id="belitan_delta_ada_{{ $gardu->id }}"
                    class="form-check-input">
                <label for="belitan_delta_ada_{{ $gardu->id }}" class="form-check-label">Ada</label>

                <input type="radio" name="belitan_delta" value="tidak_ada" id="belitan_delta_tidak_ada_{{ $gardu->id }}"
                    class="form-check-input" checked>
                <label for="belitan_delta_tidak_ada_{{ $gardu->id }}" class="form-check-label">Tidak Ada</label>
            </div>

            <div class="form-group">
                <label for="kapasitas_delta_{{ $gardu->id }}">Kapasitas Delta (MVA)</label>
                <input type="number" step="0.01" name="kapasitas_delta" class="form-control"
                    id="kapasitas_delta_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateKapasitasDeltaBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate Kapasitas Delta</button>

            <div class="form-group">
                <label for="i_nominal_20kv_{{ $gardu->id }}">I Nominal 20kV (Ampere)</label>
                <input type="number" step="0.01" name="i_nominal_20kv" class="form-control"
                    id="i_nominal_20kv_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateINominalBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate I Nominal 20kV</button>

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
                <label for="pentanahan_netral">Pentanahan Netral (Ohm)</label>
                <input type="number" step="0.01" name="pentanahan_netral" class="form-control"
                    id="pentanahan_netral{{ $gardu->id }}" required>
            </div>

            <!-- XT Calculations -->
            <div class="form-group">
                <label for="xt_1_{{ $gardu->id }}">XT 1 (Ohm)</label>
                <input type="number" step="0.01" name="xt_1" class="form-control" id="xt_1_{{ $gardu->id }}" required
                    readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateXT1Btn"
                data-gardu-id="{{ $gardu->id }}">Calculate XT 1</button>

            <div class="form-group">
                <label for="xt_0_{{ $gardu->id }}">XT 0 (Ohm)</label>
                <input type="number" step="0.01" name="xt_0" class="form-control" id="xt_0_{{ $gardu->id }}" required
                    readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateXT0Btn"
                data-gardu-id="{{ $gardu->id }}">Calculate XT 0</button>

            <!-- XLPE-AL Cable -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="xlpe_al_cable_{{ $gardu->id }}">XLPE-AL Cable (mH/km)</label>
                    <input type="number" step="0.001" name="inductance_per_km" class="form-control"
                        id="xlpe_al_cable_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="xlpe_al_cable_output_{{ $gardu->id }}">XLPE-AL Cable (ωL)</label>
                    <input type="number" step="0.01" name="xlpe_al_cable" class="form-control"
                        id="xlpe_al_cable_output_{{ $gardu->id }}" required readonly>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateXLPEALCableBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate XLPE-AL Cable</button>

            <!-- Impedansi Penyulang 20kV -->
            <h5 class="mt-4">IMPEDANSI PENYULANG 20kV</h5>
            <p>Data impedansi jaringan/km</p>

            <div class="form-group">
                <label for="z1_km_{{ $gardu->id }}">Z1/km</label>
                <input type="number" step="0.001" name="z1_km" class="form-control" id="z1_km_{{ $gardu->id }}"
                    required>
            </div>

            <div class="form-group">
                <label for="z1_km_output_{{ $gardu->id }}"></label>
                <input type="number" step="0.01" name="z1_km_output" class="form-control"
                    id="z1_km_output_{{ $gardu->id }}" required readonly>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateZ1KmBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate Z1/km</button>

            <div class="form-group">
                <label>Z0/km</label>
                <div>
                    <input type="number" step="0.01" name="z0_km_1" class="form-control" id="z0_km_{{ $gardu->id }}_1"
                        required readonly>
                </div>
                <div>
                    <input type="number" step="0.01" name="z0_km_2" class="form-control" id="z0_km_{{ $gardu->id }}_2"
                        required readonly>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="calculateZ0KmBtn"
                data-gardu-id="{{ $gardu->id }}">Calculate Z0/km</button>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="">Seksi GI-GH1</label>
                    <input type="number" step="0.01" name="seksi_gi_gh1" class="form-control"
                        id="seksi_gi_gh1_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="">Seksi G1-ujung</label>
                    <input type="number" step="0.01" name="seksi_g1_ujung" class="form-control"
                        id="seksi_g1_ujung_{{ $gardu->id }}" required>
                </div>
            </div>

            <!-- Z1 and Z0 Table -->
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
                        <td><input type="text" class="form-control" name="ri1_z1" id="ri1_z1_{{ $gardu->id }}" required
                                readonly></td>
                        <td>RI1</td>
                        <td><input type="text" class="form-control" name="ri1_z0" id="ri1_z0_{{ $gardu->id }}" required
                                readonly></td>
                    </tr>
                    <tr>
                        <td>j XI1</td>
                        <td><input type="text" class="form-control" name="j_xi1_z1" id="j_xi1_z1_{{ $gardu->id }}"
                                required readonly></td>
                        <td>j XI1</td>
                        <td><input type="text" class="form-control" name="j_xi1_z0" id="j_xi1_z0_{{ $gardu->id }}"
                                required readonly></td>
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
                            <button type="button" class="btn btn-primary" id="calculateAllBtn"
                                data-gardu-id="{{ $gardu->id }}">Calculate All</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Summary Impedansi -->
            <h5 class="mt-4">SUMMARY IMPEDANSI (IMPEDANSI URUTAN POSITIF)</h5>

            <!-- R1 Sumber & X1 Sumber -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_sumber_{{ $gardu->id }}">R1 sumber</label>
                    <input type="number" step="0.01" name="r1_sumber" class="form-control"
                        id="r1_sumber_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="x1_sumber_{{ $gardu->id }}">X1 sumber</label>
                    <input type="number" step="0.01" name="x1_sumber" class="form-control"
                        id="x1_sumber_{{ $gardu->id }}" required readonly>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateX1SumberBtn"
                    data-gardu-id="{{ $gardu->id }}">Calculate X1 Sumber</button>
            </div>

            <!-- R1 Trafo & X1 Trafo -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_trafo_{{ $gardu->id }}">R1 trafo</label>
                    <input type="number" step="0.01" name="r1_trafo" class="form-control" id="r1_trafo_{{ $gardu->id }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="x1_trafo_{{ $gardu->id }}">X1 trafo</label>
                    <input type="number" step="0.01" name="x1_trafo" class="form-control" id="x1_trafo_{{ $gardu->id }}"
                        required readonly>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateX1TrafoBtn"
                    data-gardu-id="{{ $gardu->id }}">Calculate X1 Trafo</button>
            </div>

            <p>Z1 Ekivalen</p>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_gi_gh1_{{ $gardu->id }}">R1 GI-GH1</label>
                    <input type="number" step="0.01" name="r1_gi_gh1" class="form-control"
                        id="r1_gi_gh1_{{ $gardu->id }}" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="x1_gi_gh1_{{ $gardu->id }}">X1 GI-GH1</label>
                    <input type="number" step="0.01" name="x1_gi_gh1" class="form-control"
                        id="x1_gi_gh1_{{ $gardu->id }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_gh1_ujung_{{ $gardu->id }}">R1GH1-ujung</label>
                    <input type="number" step="0.01" name="r1_gh1_ujung" class="form-control"
                        id="r1_gh1_ujung_{{ $gardu->id }}" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="x1_gh1_ujung_{{ $gardu->id }}">X1GH1-ujung</label>
                    <input type="number" step="0.01" name="x1_gh1_ujung" class="form-control"
                        id="x1_gh1_ujung_{{ $gardu->id }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="z1_r1gi_flt_{{ $gardu->id }}">R1GI-Flt</label>
                    <input type="number" step="0.0001" name="z1_r1gi_flt" class="form-control"
                        id="z1_r1gi_flt_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="z1_x1gi_flt_{{ $gardu->id }}">X1GI-Flt</label>
                    <input type="number" step="0.00001" name="z1_x1gi_flt" class="form-control"
                        id="z1_x1gi_flt_{{ $gardu->id }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateAll2Btn"
                    data-gardu-id="{{ $gardu->id }}">Calculate All</button>
            </div>


            <h6 class="mt-4">IMPEDANSI HUBUNHAN SINGKAT PENYULANG DI GI</h6>
            <p>Z0 Ekivalen</p>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="z0_r1gi_flt_{{ $gardu->id }}">R1GI-Flt</label>
                    <input type="number" step="0.0001" name="z0_r1gi_flt" class="form-control"
                        id="z0_r1gi_flt_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="z0_x1gi_flt_{{ $gardu->id }}">X1GI-Flt</label>
                    <input type="number" step="0.001" name="z0_x1gi_flt" class="form-control"
                        id="z0_x1gi_flt_{{ $gardu->id }}" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm">
                    <label for="3_fasa_{{ $gardu->id }}">3 FASA</label>
                    <input type="number" step="0.01" name="3_fasa" class="form-control" id="3_fasa_{{ $gardu->id }}"
                        required readonly>
                </div>
                <div class="col-sm">
                    <label for="2_fasa_{{ $gardu->id }}">2 FASA</label>
                    <input type="number" step="0.01" name="2_fasa" class="form-control" id="2_fasa_{{ $gardu->id }}"
                        required readonly>
                </div>
                <div class="col-sm">
                    <label for="1_fasa_{{ $gardu->id }}">1 FASA</label>
                    <input type="number" step="0.01" name="1_fasa" class="form-control" id="1_fasa_{{ $gardu->id }}"
                        required readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="lok_gangg_{{ $gardu->id }}">Lok.gangg</label>
                <input type="number" step="0.01" name="lok_gangg" class="form-control" id="lok_gangg_{{ $gardu->id }}"
                    required readonly>
            </div>

            <div class="form-group">
                <label for="pnj_jar_{{ $gardu->id }}">%pnj jar</label>
                <input type="number" step="0.01" name="pnj_jar" class="form-control" id="pnj_jar_{{ $gardu->id }}"
                    required readonly>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateAll3Btn"
                    data-gardu-id="{{ $gardu->id }}">Calculate All</button>
            </div>

            <!-- Impedansi Urutan Positif -->
            <h5 class="mt-4">IMPEDANSI URUTAN NOL</h5>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_sumber2_{{ $gardu->id }}">R1 sumber</label>
                    <input type="number" step="0.01" name="r1_sumber2" class="form-control"
                        id="r1_sumber2_{{ $gardu->id }}" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="x1_sumber2_{{ $gardu->id }}">X1 sumber</label>
                    <input type="number" step="0.01" name="x1_sumber2" class="form-control"
                        id="x1_sumber2_{{ $gardu->id }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateR1Sumber2Btn"
                    data-gardu-id="{{ $gardu->id }}">Calculate R1 Sumber</button>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_trafo2_{{ $gardu->id }}">R1 trafo</label>
                    <input type="number" step="0.01" name="r1_trafo2" class="form-control"
                        id="r1_trafo2_{{ $gardu->id }}" required>
                </div>
                <div class="col-md-6">
                    <label for="x1_trafo2_{{ $gardu->id }}">X1 trafo</label>
                    <input type="number" step="0.01" name="x1_trafo2" class="form-control"
                        id="x1_trafo2_{{ $gardu->id }}" required readonly>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateX1Trafo2Btn"
                    data-gardu-id="{{ $gardu->id }}">Calculate X1 Trafo</button>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_gh1_ujung2_{{ $gardu->id }}">R1GH1-ujung</label>
                    <input type="number" step="0.01" name="r1_gh1_ujung2" class="form-control"
                        id="r1_gh1_ujung2_{{ $gardu->id }}" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="x1_gh1_ujung2_{{ $gardu->id }}">X1GH1-ujung</label>
                    <input type="number" step="0.01" name="x1_gh1_ujung2" class="form-control"
                        id="x1_gh1_ujung2_{{ $gardu->id }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="r1_gi_gh1_2_{{ $gardu->id }}">R1 GI-GH1</label>
                    <input type="number" step="0.0001" name="r1gi_flt2" class="form-control"
                        id="r1_gi_gh1_2_{{ $gardu->id }}" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="x1_gi_gh1_2_{{ $gardu->id }}">X1 GI-GH1</label>
                    <input type="number" step="0.001" name="x1gi_flt1_2" class="form-control"
                        id="x1_gi_gh1_2_{{ $gardu->id }}" required readonly>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="calculateAll4Btn"
                    data-gardu-id="{{ $gardu->id }}">Calculate All</button>
            </div>

            <div class="form-group">
                <label for="lok_gangg2_{{ $gardu->id }}">Lok.gangg</label>
                <input type="number" step="0.01" name="lok_gangg2" class="form-control" id="lok_gangg2_{{ $gardu->id }}"
                    required readonly>
            </div>

            <div class="form-group">
                <label for="pnj_jar2_{{ $gardu->id }}">%pnj jar</label>
                <input type="number" step="0.01" name="pnj_jar2" class="form-control" id="pnj_jar2_{{ $gardu->id }}"
                    required readonly>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" id="LokkGanggPnjJarBtn"
                    data-gardu-id="{{ $gardu->id }}">Calculate Lokk.gangg dan %pnj jar</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">Add Impedansi Trafo</button>
        </form>
    </td>
</tr>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/form.js') }}"></script>