<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class KerusakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kerusakans = Kerusakan::all();
        return view('teknisi.kerusakan.index', compact('kerusakans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teknisi.kerusakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:kerusakans',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Kerusakan::create($request->all());

        return redirect()->route('kerusakan.index')
            ->with('success', 'Kerusakan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kerusakan $kerusakan)
    {
        return view('teknisi.kerusakan.show', compact('kerusakan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kerusakan $kerusakan)
    {
        return view('teknisi.kerusakan.edit', compact('kerusakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kerusakan $kerusakan)
    {
        $request->validate([
            'kode' => 'required|string|unique:kerusakans,kode,' . $kerusakan->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kerusakan->update($request->all());

        return redirect()->route('kerusakan.index')
            ->with('success', 'Kerusakan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kerusakan $kerusakan)
    {
        // Periksa apakah kerusakan digunakan dalam aturan atau solusi
        if ($kerusakan->aturans()->count() > 0 || $kerusakan->solusis()->count() > 0) {
            return redirect()->route('kerusakan.index')
                ->with('error', 'Kerusakan tidak dapat dihapus karena masih digunakan dalam aturan atau solusi.');
        }

        $kerusakan->delete();

        return redirect()->route('kerusakan.index')
            ->with('success', 'Kerusakan berhasil dihapus.');
    }
}
