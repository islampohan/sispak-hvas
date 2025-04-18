<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\RiwayatKerusakan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PredictiveMaintenanceController extends Controller
{
    /**
     * Tampilkan form input untuk predictive maintenance
     */
    public function index()
    {
        $kerusakans = Kerusakan::all();
        $komponens = RiwayatKerusakan::select('komponen')
            ->distinct()
            ->pluck('komponen');

        return view('user.predictive-maintenance.index', compact('kerusakans', 'komponens'));
    }

    /**
     * Hitung MTBF dan prediksi kerusakan berikutnya
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'komponen' => 'required|string',
            'tanggal_kerusakan' => 'required|array',
            'tanggal_kerusakan.*' => 'required|date',
        ]);

        $komponen = $request->komponen;
        $tanggalKerusakan = collect($request->tanggal_kerusakan)
            ->map(function ($tanggal) {
                return Carbon::parse($tanggal);
            })
            ->sort();

        if ($tanggalKerusakan->count() < 2) {
            return redirect()->route('predictive-maintenance.index')
                ->with('error', 'Minimal diperlukan 2 tanggal kerusakan untuk menghitung MTBF.');
        }

        // Hitung rata-rata selisih hari antar kerusakan (MTBF)
        $totalSelisih = 0;
        $jumlahSelisih = 0;

        for ($i = 1; $i < $tanggalKerusakan->count(); $i++) {
            $selisih = $tanggalKerusakan[$i]->diffInDays($tanggalKerusakan[$i-1]);
            $totalSelisih += $selisih;
            $jumlahSelisih++;
        }

        $mtbf = $totalSelisih / $jumlahSelisih;

        // Prediksi tanggal kerusakan berikutnya
        $tanggalTerakhir = $tanggalKerusakan->last();
        $prediksiKerusakanBerikutnya = $tanggalTerakhir->copy()->addDays(round($mtbf));

        // Simpan hasil ke session
        session()->put('hasil_mtbf', [
            'komponen' => $komponen,
            'mtbf' => $mtbf,
            'tanggal_terakhir' => $tanggalTerakhir->format('Y-m-d'),
            'prediksi_kerusakan' => $prediksiKerusakanBerikutnya->format('Y-m-d'),
            'riwayat_tanggal' => $tanggalKerusakan->map->format('Y-m-d')->toArray(),
        ]);

        return redirect()->route('predictive-maintenance.result');
    }

    /**
     * Tampilkan hasil perhitungan MTBF
     */
    public function result()
    {
        if (!session()->has('hasil_mtbf')) {
            return redirect()->route('predictive-maintenance.index');
        }

        $hasil = session()->get('hasil_mtbf');

        return view('user.predictive-maintenance.hasil', compact('hasil'));
    }
}
