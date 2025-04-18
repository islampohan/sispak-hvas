<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Aturan;
use App\Models\Konsultasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teknisi');
    }

    /**
     * Show the teknisi dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalGejala = Gejala::count();
        $totalKerusakan = Kerusakan::count();
        $totalAturan = Aturan::count();

        // Data untuk grafik tren kerusakan
        $kerusakanTrend = Konsultasi::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('COUNT(*) as total')
        )
        ->whereNotNull('kerusakan_id')
        ->where('tanggal', '>=', Carbon::now()->subMonths(6))
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get()
        ->map(function ($item) {
            $bulanNama = Carbon::createFromDate(null, $item->bulan, 1)->locale('id')->monthName;
            return [
                'bulan' => $bulanNama . ' ' . $item->tahun,
                'total' => $item->total
            ];
        });

        return view('teknisi.dashboard', compact('totalGejala', 'totalKerusakan', 'totalAturan', 'kerusakanTrend'));
    }
}
