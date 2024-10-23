<?php

namespace App\Http\Controllers;

use App\Models\ImpedansiTrafo;
use App\Models\Gardu;
use Illuminate\Http\Request;

class ImpedansiTrafoController extends Controller
{
    public function index()
    {
        $impedansiTrafo = ImpedansiTrafo::with('gardu')->get();
        return view('impedansi_trafo.index', compact('impedansiTrafo'));
    }

    public function create()
    {
        $gardus = Gardu::all();
        return view('impedansi_trafo.create', compact('gardus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_gardu' => 'nullable|exists:gardu,id',
            'mva_short_circuit' => 'nullable|numeric',
            'mva_di_busbar' => 'nullable|numeric',
            'kapasitas' => 'nullable|numeric',
            'impedansi_trafo' => 'nullable|numeric',
            'volt_primer' => 'nullable|numeric',
            'volt_sekunder' => 'nullable|numeric',
            'belitan_delta' => 'nullable|string|max:255',
            'kapasitas_delta' => 'nullable|numeric',
            'ratio_c_t_20kv_1' => 'nullable|numeric',
            'ratio_c_t_20kv_2' => 'nullable|numeric',
            'pentahanan_netral' => 'nullable|numeric',
            'xt_1' => 'nullable|numeric',
            'i_nominal_20kv' => 'nullable|numeric',
            'impedansi_sumber' => 'nullable|numeric',
        ]);

        ImpedansiTrafo::create($request->all());
        return redirect()->route('impedansi_trafo.index')->with('success', 'Impedansi Trafo berhasil ditambahkan.');
    }

    public function edit(ImpedansiTrafo $impedansiTrafo)
    {
        $gardus = Gardu::all();
        return view('impedansi_trafo.edit', compact('impedansiTrafo', 'gardus'));
    }

    public function update(Request $request, ImpedansiTrafo $impedansiTrafo)
    {
        $request->validate([
            'id_gardu' => 'nullable|exists:gardu,id',
            // Validasi lainnya...
        ]);

        $impedansiTrafo->update($request->all());
        return redirect()->route('impedansi_trafo.index')->with('success', 'Impedansi Trafo berhasil diperbarui.');
    }

    public function destroy(ImpedansiTrafo $impedansiTrafo)
    {
        $impedansiTrafo->delete();
        return redirect()->route('impedansi_trafo.index')->with('success', 'Impedansi Trafo berhasil dihapus.');
    }
}