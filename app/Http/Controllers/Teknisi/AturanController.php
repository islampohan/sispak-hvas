<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class AturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aturans = Aturan::with(['kerusakan', 'gejalas'])->get();
        return view('teknisi.aturan.index', compact('aturans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kerusakans = Kerusakan::all();
        return view('teknisi.aturan.create', compact('kerusakans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:aturans',
            'kerusakan_id' => 'required|exists:kerusakans,id',
        ]);

        $aturan = Aturan::create($request->all());

        return redirect()->route('aturan.edit', $aturan)
            ->with('success', 'Aturan berhasil dibuat. Silakan tambahkan gejala untuk aturan ini.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aturan $aturan)
    {
        $aturan->load(['kerusakan', 'gejalas']);
        return view('teknisi.aturan.show', compact('aturan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aturan $aturan)
    {
        $kerusakans = Kerusakan::all();
        $aturan->load('gejalas');

        // Gejala yang belum ditambahkan ke aturan
        $gejalasTersedia = Gejala::whereNotIn('id', $aturan->gejalas->pluck('id'))->get();

        return view('teknisi.aturan.edit', compact('aturan', 'kerusakans', 'gejalasTersedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aturan $aturan)
    {
        $request->validate([
            'kode' => 'required|string|unique:aturans,kode,' . $aturan->id,
            'kerusakan_id' => 'required|exists:kerusakans,id',
        ]);

        $aturan->update($request->all());

        return redirect()->route('aturan.index')
            ->with('success', 'Aturan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aturan $aturan)
    {
        // Hapus relasi dengan gejala
        $aturan->gejalas()->detach();
        $aturan->delete();

        return redirect()->route('aturan.index')
            ->with('success', 'Aturan berhasil dihapus.');
    }

    /**
     * Tambahkan gejala ke aturan.
     */
    public function addGejala(Request $request, Aturan $aturan)
    {
        $request->validate([
            'gejala_id' => 'required|exists:gejalas,id',
        ]);

        // Periksa apakah gejala sudah ada dalam aturan
        if (!$aturan->gejalas()->where('gejala_id', $request->gejala_id)->exists()) {
            $aturan->gejalas()->attach($request->gejala_id);
            return redirect()->route('aturan.edit', $aturan)
                ->with('success', 'Gejala berhasil ditambahkan ke aturan.');
        }

        return redirect()->route('aturan.edit', $aturan)
            ->with('error', 'Gejala sudah ada dalam aturan ini.');
    }

    /**
     * Hapus gejala dari aturan.
     */
    public function removeGejala(Aturan $aturan, Gejala $gejala)
    {
        $aturan->gejalas()->detach($gejala->id);
        return redirect()->route('aturan.edit', $aturan)
            ->with('success', 'Gejala berhasil dihapus dari aturan.');
    }
}
