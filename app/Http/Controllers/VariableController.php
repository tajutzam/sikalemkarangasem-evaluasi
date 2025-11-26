<?php

namespace App\Http\Controllers;

use App\Models\Variabel;
use Illuminate\Http\Request;

class VariableController extends Controller
{

    public function index()
    {
        $variabel = Variabel::ordered()->paginate(10);
        return view('variabel.index', compact('variabel'));
    }

    public function create()
    {
        return view('variabel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_variabel' => 'required|string|max:255|unique:variabel,kode_variabel',
            'nama_variabel' => 'required|string|max:255',
            'urutan' => 'required|integer',
        ]);

        Variabel::create($request->all());

        return redirect()->route('variabel.index')->with('success', 'Variabel berhasil ditambahkan.');
    }

    public function edit(Variabel $variabel)
    {
        return view('variabel.edit', compact('variabel'));
    }

    public function update(Request $request, Variabel $variabel)
    {
        $request->validate([
            'kode_variabel' => 'required|string|max:255|unique:variabel,kode_variabel,' . $variabel->id,
            'nama_variabel' => 'required|string|max:255',
            'urutan' => 'required|integer',
        ]);

        $variabel->update($request->all());

        return redirect()->route('variabel.index')->with('success', 'Variabel berhasil diperbarui.');
    }

    public function destroy(Variabel $variabel)
    {
        $variabel->delete();

        return redirect()->route('variabel.index')->with('success', 'Variabel berhasil dihapus.');
    }
}
