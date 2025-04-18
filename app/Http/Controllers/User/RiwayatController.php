<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use PDF;

class RiwayatController extends Controller
{
    /**
     * Tampilkan riwayat konsultasi pengguna
     */
    public function index()
    {
        $konsultasis = Konsultasi::with(['kerusakan'])
            ->where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('user.riwayat.index', compact('konsultasis'));
    }

    /**
     * Tampilkan detail riwayat konsultasi
     */
    public function show(Konsultasi $konsultasi)
    {
        // Pastikan pengguna hanya melihat konsultasinya sendiri
        if ($konsultasi->user_id !== auth()->id()) {
            return redirect()->route('riwayat.index')
                ->with('error', 'Anda tidak memiliki izin untuk melihat riwayat ini.');
        }

        $konsultasi->load(['kerusakan', 'kerusakan.solusis', 'detailKonsultasis.gejala']);

        return view('user.riwayat.show', compact('konsultasi'));
    }

    /**
     * Generate PDF dari riwayat konsultasi
     */
    public function generatePdf(Konsultasi $konsultasi)
    {
        // Pastikan pengguna hanya mengakses konsultasinya sendiri
        if ($konsultasi->user_id !== auth()->id()) {
            return redirect()->route('riwayat.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses riwayat ini.');
        }

        $konsultasi->load(['kerusakan', 'kerusakan.solusis', 'detailKonsultasis.gejala', 'user']);

        $pdf = PDF::loadView('user.riwayat.pdf', compact('konsultasi'));

        return $pdf->download('konsultasi-' . $konsultasi->id . '.pdf');
    }
}
