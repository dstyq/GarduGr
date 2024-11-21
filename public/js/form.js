document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-gardu-id]').forEach(button => {
        const garduId = button.getAttribute('data-gardu-id');
        const buttonActions = {
            'calculateImpedanceBtn': calculateImpedance,
            'calculateKapasitasDeltaBtn': calculateKapasitasDelta,
            'calculateINominalBtn': calculateINominal,
            'calculateXT1Btn': calculateXT1,
            'calculateXT0Btn': calculateXT0,
            'calculateXLPEALCableBtn': calculateXLPEALCable,
            'calculateZ1KmBtn': calculateZ1Km,
            'calculateZ0KmBtn': calculateZ0Km,
            'calculateAllBtn': calculateAll,
            'calculateX1SumberBtn': calculateX1Sumber,
            'calculateX1TrafoBtn': calculateX1Trafo,
            'calculateAllBtn2': calculateAll2,
            'calculateAllBtn3': calculateAll3,
            'calculateAllBtn4': calculateAll4,
            'LokkGanggPnjJarBtn': calculateLokkGanggPnjJar
        };

        if (buttonActions[button.id]) {
            button.addEventListener('click', function () {
                buttonActions[button.id](garduId);
            });
        }
    });
});

function getNumericValue(id, defaultValue = 0) {
    const value = parseFloat(document.getElementById(id).value);
    return isNaN(value) ? defaultValue : value;
}

// Show error message on the UI
function showError(message) {
    alert(message);
}

// Function to calculate impedansi sumber 
function calculateImpedance(garduId) {
    const mvaShortCircuit = getNumericValue('mva_short_circuit_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_' + garduId);

    if (mvaShortCircuit > 0 && voltSekunder > 0) {
        const impedanceSumber = (voltSekunder ** 2) / mvaShortCircuit;
        document.getElementById('impedansi_sumber_' + garduId).value = impedanceSumber.toFixed(7);
    } else {
        showError('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
    }
}

// Function to calculate kapasitas delta
function calculateKapasitasDelta(garduId) {
    const mvaKapasitas = getNumericValue('kapasitas_' + garduId);
    const voltSekunderDelta = getNumericValue('volt_sekunder_2_' + garduId);

    if (mvaKapasitas > 0 && voltSekunderDelta > 0) {
        const kapasitasDelta = mvaKapasitas / 3;
        document.getElementById('kapasitas_delta_' + garduId).value = kapasitasDelta.toFixed(0);
    } else {
        showError('Please enter valid values for MVA Kapasitas and Volt Sekunder Delta.');
    }
}

// Function to calculate I Nominal
function calculateINominal(garduId) {
    const kapasitas = getNumericValue('kapasitas_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_2_' + garduId);

    if (voltSekunder > 0) {
        const iNominal = (kapasitas * 1000) / (voltSekunder * Math.sqrt(3));
        document.getElementById('i_nominal_20kv_' + garduId).value = iNominal.toFixed(6);
    } else {
        showError('Please enter a valid value for Volt Sekunder to calculate I Nominal.');
    }
}

// Function to calculate XT1
function calculateXT1(garduId) {
    const impedansiTrafo = getNumericValue('impedansi_trafo_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_2_' + garduId);
    const kapasitas = getNumericValue('kapasitas_' + garduId);

    if (impedansiTrafo > 0 && voltSekunder > 0 && kapasitas > 0) {
        const xt1 = (impedansiTrafo / 100) * (voltSekunder ** 2) / kapasitas;
        document.getElementById('xt_1_' + garduId).value = xt1.toFixed(9);
    } else {
        showError('Please enter valid values for Impedansi Trafo, Volt Sekunder, and Kapasitas to calculate XT 1.');
    }
}

// Function to calculate XT0
function calculateXT0(garduId) {
    const belitanDelta = document.querySelector('input[name="belitan_delta"]:checked').value;
    const xt1 = getNumericValue('xt_1_' + garduId);
    const kapasitas = getNumericValue('kapasitas_' + garduId);
    const kapasitasDelta = getNumericValue('kapasitas_delta_' + garduId);

    let xt0;
    if (belitanDelta === 'ada') {
        xt0 = (kapasitas / kapasitasDelta) * xt1;
    } else {
        xt0 = xt1 * 10;
    }
    document.getElementById('xt_0_' + garduId).value = xt0.toFixed(1);
}

// Function to calculate XLPE-AL Cable
function calculateXLPEALCable(garduId) {
    const inductance = getNumericValue('xlpe_al_cable_' + garduId);

    const pi = 3.141592653589793;

    if (inductance > 0) {
        const xlpeALCable = (2 * pi * 50 * inductance) / 1000;
        document.getElementById('xlpe_al_cable_output_' + garduId).value = xlpeALCable.toFixed(9);
    } else {
        showError('Please enter a valid value for Inductance.');
    }
}

// Function to calculate Z1/km and Z1/km output
function calculateZ1Km(garduId) {
    const z1Km = getNumericValue('z1_km_' + garduId);
    const inductance = getNumericValue('xlpe_al_cable_' + garduId);
    const pi = 3.141592653589793;

    if (z1Km > 0 && inductance > 0) {
        const z1KmOutput = (2 * pi * 50 * inductance) / 1000;
        document.getElementById('z1_km_output_' + garduId).value = z1KmOutput.toFixed(9);
    } else {
        showError('Please enter valid values for Z1/km and Inductance.');
    }
}


// Function to calculate Z0/km
function calculateZ0Km(garduId) {
    const z1Km = getNumericValue('z1_km_' + garduId);
    const z1KmOutput = getNumericValue('z1_km_output_' + garduId);

    if (z1Km > 0 && z1KmOutput > 0) {
        const z0Km1 = 2.2 * z1Km;
        const z0Km2 = 3 * z1KmOutput;

        document.getElementById('z0_km_' + garduId + '_1').value = z0Km1.toFixed(3);
        document.getElementById('z0_km_' + garduId + '_2').value = z0Km2.toFixed(9);
    } else {
        showError('Please enter valid values for Z1/km and Z1/km Output to calculate Z0/km.');
    }
}

// Function to calculate All Z1 Jar and Z0 Jar
function calculateAll(garduId) {
    const z1Km = getNumericValue('z1_km_' + garduId);
    const z1KmOutput = getNumericValue('z1_km_output_' + garduId);
    const seksiGI = getNumericValue('seksi_gi_gh1_' + garduId);
    const seksiG1 = getNumericValue('seksi_g1_ujung_' + garduId);

    if (z1Km > 0 && z1KmOutput > 0 && seksiGI > 0 && seksiG1 > 0) {
        const ri1Z1 = z1Km * seksiGI;
        const xi1Z1 = z1KmOutput * seksiGI;
        const ri2Z1 = z1Km * seksiG1;
        const xi2Z1 = z1KmOutput * seksiG1;

        const ri1Z0 = seksiGI * 2.2 * z1Km;
        const xi1Z0 = seksiGI * 3 * z1KmOutput;
        const ri2Z0 = seksiG1 * 2.2 * z1Km;
        const xi2Z0 = seksiG1 * 3 * z1KmOutput;

        document.getElementsByName('ri1_z1')[0].value = ri1Z1.toFixed(2);
        document.getElementsByName('j_xi1_z1')[0].value = xi1Z1.toFixed(5);
        document.getElementsByName('ri2_z1')[0].value = ri2Z1.toFixed(2);
        document.getElementsByName('j_xi2_z1')[0].value = xi2Z1.toFixed(5);

        document.getElementsByName('ri1_z0')[0].value = ri1Z0.toFixed(2);
        document.getElementsByName('j_xi1_z0')[0].value = xi1Z0.toFixed(5);
        document.getElementsByName('ri2_z0')[0].value = ri2Z0.toFixed(2);
        document.getElementsByName('j_xi2_z0')[0].value = xi2Z0.toFixed(5);
    } else {
        showError('Please enter valid values for Z1/km, Z1/km Output, Seksi GI, and Seksi G1.');
    }
}

// Function to calculate X1 Sumber
function calculateX1Sumber(garduId) {
    const mvaShortCircuit = getNumericValue('mva_short_circuit_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_' + garduId);    

    if (mvaShortCircuit > 0 && voltSekunder > 0) {
        const x1Sumber = (voltSekunder ** 2) / mvaShortCircuit;
        document.getElementById('x1_sumber_' + garduId).value = x1Sumber.toFixed(5); 
    } else {
        showError('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
    }
}

// Function to calculate X1 Trafo
function calculateX1Trafo(garduId) {
    const impedansiTrafo = getNumericValue('impedansi_trafo_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_' + garduId);
    const kapasitas = getNumericValue('kapasitas_' + garduId);

    if (impedansiTrafo > 0 && voltSekunder > 0 && kapasitas > 0) {
        const x1Trafo = (impedansiTrafo / 100) * (voltSekunder ** 2) / kapasitas;
        document.getElementById('x1_trafo_' + garduId).value = x1Trafo.toFixed(7);
    } else {
        showError('Please enter valid values for Impedansi Trafo, Volt Sekunder, and Kapasitas to calculate X1 Trafo.');
    }
}

// Function to calculate R1 GI-GH1, X1 GI-GH1, R1GH1-ujung, X1GH1-ujung(All 2)
function calculateAll2(garduId) {
    const z1R1giFlt = getNumericValue('z1_r1gi_flt_' + garduId);
    const r1Sumber = getNumericValue('r1_sumber_' + garduId);
    const r1Trafo = getNumericValue('r1_trafo_' + garduId);
    const r12Z1 = getNumericValue('ri2_z1_' + garduId);

    const z1X1giFlt = getNumericValue('z1_x1gi_flt_' + garduId);
    const x1Sumber = getNumericValue('x1_sumber_' + garduId);
    const x1Trafo = getNumericValue('x1_trafo_' + garduId);
    const jXi2Z1 = getNumericValue('j_xi2_z1_' + garduId);

    if (z1R1giFlt > 0 && r1Sumber > 0 && r1Trafo > 0 && r1GH1Ujung >= 0 && x1Sumber > 0 && x1Trafo > 0 && x1GH1Ujung >= 0) {
        const r1GI_GH1 = z1R1giFlt - r1Sumber - r1Trafo - r12Z1;

        const x1GI_GH1 = z1X1giFlt - x1Sumber - x1Trafo - jXi2Z1;

        const r1GH1_Ujung = 0 * r12Z1;

        const x1GH1_Ujung = 0 * jXi2Z1;

        document.getElementById('r1_gi_gh1_' + garduId).value = r1GI_GH1.toFixed(2);
        document.getElementById('x1_gi_gh1_' + garduId).value = x1GI_GH1.toFixed(2);
        document.getElementById('r1_gh1_ujung_' + garduId).value = r1GH1UjungOutput.toFixed(2);
        document.getElementById('x1_gh1_ujung_' + garduId).value = x1GH1UjungOutput.toFixed(2);
    } else {
        showError('Please enter valid values for ....');
    }
}

// Function to calculate FASA3, FASA 2, FASA 1, Lokk.gangg, %pnj jar(all3)
function calculateAll3() {
    // Retrieve input values
    const voltSekunder = parseFloat(document.getElementById("volt_sekunder").value);
    const z1R1GiFlt = parseFloat(document.getElementById("z1_r1gi_flt").value);
    const z1X1GiFlt = parseFloat(document.getElementById("z1_x1gi_flt").value);
    const z0R1GiFlt = parseFloat(document.getElementById("z0_r1gi_flt").value);
    const z0X1GiFlt = parseFloat(document.getElementById("z0_x1gi_flt").value);
    const r1GiGh1 = parseFloat(document.getElementById("r1_gi_gh1").value);
    const ri1Z1 = parseFloat(document.getElementById("ri1_z1").value);
    const x1GiGh1 = parseFloat(document.getElementById("x1_gi_gh1").value);
    const jXi1Z1 = parseFloat(document.getElementById("j_xi1_z1").value);

    if (voltSekunder > 0 && z1R1GiFlt > 0 && z1X1GiFlt > 0 && z0R1GiFlt > 0 && z0X1GiFlt > 0 && r1GiGh1 > 0 && ri1Z1 > 0 && x1GiGh1 > 0 && jXi1Z1 > 0) {

        const fasa3 = (voltSekunder / Math.sqrt(3)) * 1000 / Math.sqrt(Math.pow(z1R1GiFlt, 2) + Math.pow(z1X1GiFlt, 2));
        document.getElementById("fasa_3_result").value = fasa3.toFixed(2);

        const fasa2 = 3 * fasa3 * (Math.sqrt(3) / 2);
        document.getElementById("fasa_2_result").value = fasa2.toFixed(2);

        const fasa1 = 3 * (voltSekunder / Math.sqrt(3)) * 1000 / Math.sqrt(Math.pow(2 * z1R1GiFlt + z0R1GiFlt, 2) + Math.pow(2 * z1X1GiFlt + z0X1GiFlt, 2));
        document.getElementById("fasa_1_result").value = fasa1.toFixed(2);

        const lokkGangg = (r1GiGh1 / ri1Z1) * 100;
        document.getElementById("lokk_gangg_result").value = lokkGangg.toFixed(2);

        const pnjJar = (x1GiGh1 / jXi1Z1) * 100;
        document.getElementById("pnj_jar_result").value = pnjJar.toFixed(2);

    } else {
        showError("Please enter valid values for all fields.");
    }
}
