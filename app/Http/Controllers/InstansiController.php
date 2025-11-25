<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = Instansi::orderBy('nama_instansi')->paginate(10);
        return view('instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('instansi.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Instansi::create($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil ditambahkan!');
    }

    public function show(Instansi $instansi)
    {
        $instansi->load('evaluations');
        return view('instansi.show', compact('instansi'));
    }


    public function edit(Instansi $instansi)
    {
        return view('instansi.form', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $instansi->update($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil diupdate!');
    }

    public function destroy(Instansi $instansi)
    {
        if ($instansi->evaluations()->count() > 0) {
            return redirect()->route('instansi.index')
                ->with('error', 'Instansi tidak dapat dihapus karena memiliki data evaluasi!');
        }

        $instansi->delete();

        return redirect()->route('instansi.index')
            ->with('success', 'Instansi berhasil dihapus!');
    }
}
