<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Aturan;
use App\Models\User;
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
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalGejala = Gejala::count();
        $totalKerusakan = Kerusakan::count();
        $totalAturan = Aturan::count();
        $totalUser = User::count();

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

        // Data untuk graf pengguna berdasarkan peran
        $usersByRole = User::select('roles.name as role', DB::raw('COUNT(*) as total'))
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->get();

        return view('admin.dashboard', compact('totalGejala', 'totalKerusakan', 'totalAturan', 'totalUser', 'kerusakanTrend', 'usersByRole'));
    }
}
