<?php

namespace App\Http\Controllers;

use App\Models\Tingkat;
use App\Models\Variabel;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    //

    public function index()
    {
        $tingkat = Tingkat::with('variabel')
            ->orderBy('variabel_id')
            ->orderBy('tingkat')
            ->paginate(10);

        return view('tingkat.index', compact('tingkat'));
    }

    public function create()
    {
        $variabel = Variabel::ordered()->get();
        return view('tingkat.create', compact('variabel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'variabel_id' => 'required|exists:variabel,id',
            'tingkat' => 'required|integer|min:1|max:5',
            'deskripsi_indikator' => 'required|string',
        ]);

        Tingkat::create($request->all());

        return redirect()->route('tingkat.index')->with('success', 'Data tingkat berhasil ditambahkan.');
    }

    public function edit(Tingkat $tingkat)
    {
        $variabel = Variabel::ordered()->get();
        return view('tingkat.edit', compact('tingkat', 'variabel'));
    }

    public function update(Request $request, Tingkat $tingkat)
    {
        $request->validate([
            'variabel_id' => 'required|exists:variabel,id',
            'tingkat' => 'required|integer|min:1|max:5',
            'deskripsi_indikator' => 'required|string',
        ]);

        $tingkat->update($request->all());

        return redirect()->route('tingkat.index')->with('success', 'Data tingkat berhasil diperbarui.');
    }

    public function destroy(Tingkat $tingkat)
    {
        $tingkat->delete();
        return redirect()->route('tingkat.index')->with('success', 'Data tingkat berhasil dihapus.');
    }
}
