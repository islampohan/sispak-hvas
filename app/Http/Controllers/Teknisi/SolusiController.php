<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Solusi;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class SolusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solusis = Solusi::with('kerusakan')->get();
        return view('teknisi.solusi.index', compact('solusis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kerusakans = Kerusakan::all();
        return view('teknisi.solusi.create', compact('kerusakans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi' => 'required|string',
            'langkah_perbaikan' => 'required|string',
        ]);

        Solusi::create($request->all());

        return redirect()->route('solusi.index')
            ->with('success', 'Solusi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solusi $solusi)
    {
        $solusi->load('kerusakan');
        return view('teknisi.solusi.show', compact('solusi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solusi $solusi)
    {
        $kerusakans = Kerusakan::all();
        return view('teknisi.solusi.edit', compact('solusi', 'kerusakans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solusi $solusi)
    {
        $request->validate([
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi' => 'required|string',
            'langkah_perbaikan' => 'required|string',
        ]);

        $solusi->update($request->all());

        return redirect()->route('solusi.index')
            ->with('success', 'Solusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solusi $solusi)
    {
        $solusi->delete();

        return redirect()->route('solusi.index')
            ->with('success', 'Solusi berhasil dihapus.');
    }
}
