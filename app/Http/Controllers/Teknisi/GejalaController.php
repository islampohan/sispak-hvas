<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gejalas = Gejala::all();
        return view('teknisi.gejala.index', compact('gejalas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teknisi.gejala.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:gejalas',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Gejala::create($request->all());

        return redirect()->route('gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gejala $gejala)
    {
        return view('teknisi.gejala.show', compact('gejala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gejala $gejala)
    {
        return view('teknisi.gejala.edit', compact('gejala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gejala $gejala)
    {
        $request->validate([
            'kode' => 'required|string|unique:gejalas,kode,' . $gejala->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $gejala->update($request->all());

        return redirect()->route('gejala.index')
            ->with('success', 'Gejala berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gejala $gejala)
    {
        // Periksa apakah gejala digunakan dalam aturan
        if ($gejala->aturans()->count() > 0) {
            return redirect()->route('gejala.index')
                ->with('error', 'Gejala tidak dapat dihapus karena masih digunakan dalam aturan.');
        }

        $gejala->delete();

        return redirect()->route('gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}
