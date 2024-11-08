document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-gardu-id]').forEach(button => {
        const garduId = button.getAttribute('data-gardu-id');
        
        // Event listeners for each button
        if (button.id === 'calculateImpedanceBtn') {
            button.addEventListener('click', function () {
                calculateImpedance(garduId);
            });
        } else if (button.id === 'calculateKapasitasDeltaBtn') {
            button.addEventListener('click', function () {
                calculateKapasitasDelta(garduId);
            });
        } else if (button.id === 'calculateINominalBtn') {
            button.addEventListener('click', function () {
                calculateINominal(garduId);
            });
        } else if (button.id === 'calculateXT1Btn') {
            button.addEventListener('click', function () {
                calculateXT1(garduId);
            });
        } else if (button.id === 'calculateXT0Btn') {
            button.addEventListener('click', function () {
                calculateXT0(garduId);
            });
        } else if (button.id === 'calculateXLPEALCableBtn') {
            button.addEventListener('click', function () {
                calculateXLPEALCable(garduId);
            });
        } else if (button.id === 'calculateZ1KmBtn') {
            button.addEventListener('click', function () {
                calculateZ1Km(garduId);
            });
        } else if (button.id === 'calculateZ0KmBtn') {
            button.addEventListener('click', function () {
                calculateZ0Km(garduId);
            });
        } else if (button.id === 'calculateAllBtn') {
            button.addEventListener('click', function () {
                calculateAll(garduId);
            });
        }
    });
});

// General function to retrieve numeric values from inputs
function getNumericValue(id, defaultValue = 0) {
    const value = parseFloat(document.getElementById(id).value);
    return isNaN(value) ? defaultValue : value;
}

// Function to calculate impedansi sumber
function calculateImpedance(garduId) {
    const mvaShortCircuit = getNumericValue('mva_short_circuit_' + garduId);
    const voltSekunder = getNumericValue('volt_sekunder_' + garduId);

    if (mvaShortCircuit > 0 && voltSekunder > 0) {
        const impedanceSumber = (voltSekunder ** 2) / mvaShortCircuit;
        document.getElementById('impedansi_sumber_' + garduId).value = impedanceSumber.toFixed(7);
    } else {
        alert('Please enter valid values for MVA Short Circuit and Volt Sekunder.');
    }
}

// Function to calculate kapasitas delta
function calculateKapasitasDelta(garduId) {
    const mvaKapasitas = getNumericValue('kapasitas_' + garduId);
    const voltSekunderDelta = getNumericValue('volt_sekunder_2_' + garduId);

    if (mvaKapasitas > 0 && voltSekunderDelta > 0) {
        const kapasitasDelta = (mvaKapasitas * voltSekunderDelta) / Math.sqrt(3);
        document.getElementById('kapasitas_delta_' + garduId).value = kapasitasDelta.toFixed(7);
    } else {
        alert('Please enter valid values for MVA Kapasitas and Volt Sekunder Delta.');
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
        alert('Please enter a valid value for Volt Sekunder to calculate I Nominal.');
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
        alert('Please enter valid values for Impedansi Trafo, Volt Sekunder, and Kapasitas to calculate XT 1.');
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

    if (inductance > 0) {
        const xlpeALCable = (2 * Math.PI * 50 * inductance) / 1000;
        document.getElementById('xlpe_al_cable_output_' + garduId).value = xlpeALCable.toFixed(9);
    } else {
        alert('Please enter a valid value for Inductance.');
    }
}

// Function to calculate Z1/km
function calculateZ1Km(garduId) {
    const z1Km = getNumericValue('z1_km_' + garduId);
    if (z1Km > 0) {
        const z1KmOutput = z1Km * 1.1; // Example calculation
        document.getElementById('z1_km_output_' + garduId).value = z1KmOutput.toFixed(9);
    } else {
        alert('Please enter a valid value for Z1/km.');
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
        alert('Please enter valid values for Z1/km and Z1/km Output to calculate Z0/km.');
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
        alert('Please enter valid values for all inputs.');
    }
}
