<?php

namespace App\Http\Controllers;

use App\Models\Gardu;
use Illuminate\Http\Request;

class GarduController extends Controller
{
    public function index()
    {
        $gardus = Gardu::all();
        return view('gardu.index', compact('gardus'));
    }

    public function create()
    {
        return view('gardu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gardu_induk' => 'nullable|string|max:255',
        ]);

        Gardu::create($request->all());
        return redirect()->route('gardu.index')->with('success', 'Gardu berhasil ditambahkan.');
    }

    public function edit(Gardu $gardu)
    {
        return view('gardu.edit', compact('gardu'));
    }

    public function update(Request $request, Gardu $gardu)
    {
        $request->validate([
            'gardu_induk' => 'nullable|string|max:255',
        ]);

        $gardu->update($request->all());
        return redirect()->route('gardu.index')->with('success', 'Gardu berhasil diperbarui.');
    }

    public function destroy(Gardu $gardu)
    {
        $gardu->delete();
        return redirect()->route('gardu.index')->with('success', 'Gardu berhasil dihapus.');
    }
}