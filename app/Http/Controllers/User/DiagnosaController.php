<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\DetailKonsultasi;
use App\Models\Kerusakan;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosaController extends Controller
{
    protected $forwardChainingService;

    public function __construct(ForwardChainingService $forwardChainingService)
    {
        $this->forwardChainingService = $forwardChainingService;
    }

    /**
     * Tampilkan form diagnosa
     */
    public function index()
    {
        $gejalas = Gejala::all();
        return view('user.diagnosa.index', compact('gejalas'));
    }

    /**
     * Proses diagnosa menggunakan metode forward chaining
     */
    public function process(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array',
            'gejala.*' => 'exists:gejalas,id',
        ]);

        $selectedGejalaIds = $request->gejala;

        // Gunakan service Forward Chaining untuk mendapatkan hasil diagnosa
        $hasilDiagnosa = $this->forwardChainingService->diagnose($selectedGejalaIds);

        if (!$hasilDiagnosa) {
            return redirect()->route('diagnosa.index')
                ->with('error', 'Tidak dapat menentukan kerusakan berdasarkan gejala yang dipilih.');
        }

        // Simpan hasil konsultasi
        DB::beginTransaction();
        try {
            $konsultasi = Konsultasi::create([
                'user_id' => auth()->id(),
                'kerusakan_id' => $hasilDiagnosa['kerusakan']->id,
                'tanggal' => now(),
                'keterangan' => 'Konsultasi via sistem pakar',
            ]);

            // Simpan detail gejala yang dipilih
            foreach ($selectedGejalaIds as $gejalaId) {
                DetailKonsultasi::create([
                    'konsultasi_id' => $konsultasi->id,
                    'gejala_id' => $gejalaId,
                ]);
            }

            DB::commit();

            // Simpan ID konsultasi ke session untuk halaman hasil
            session()->put('hasil_diagnosa', [
                'konsultasi_id' => $konsultasi->id,
                'kerusakan' => $hasilDiagnosa['kerusakan'],
                'solusi' => $hasilDiagnosa['solusi'],
                'gejala_ids' => $selectedGejalaIds,
            ]);

            return redirect()->route('diagnosa.result');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('diagnosa.index')
                ->with('error', 'Terjadi kesalahan saat menyimpan hasil diagnosa: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan hasil diagnosa
     */
    public function result()
    {
        if (!session()->has('hasil_diagnosa')) {
            return redirect()->route('diagnosa.index');
        }

        $hasil = session()->get('hasil_diagnosa');
        $konsultasi = Konsultasi::with(['kerusakan', 'detailKonsultasis.gejala'])->findOrFail($hasil['konsultasi_id']);
        $kerusakan = $hasil['kerusakan'];
        $solusi = $hasil['solusi'];
        $gejalas = Gejala::whereIn('id', $hasil['gejala_ids'])->get();

        return view('user.diagnosa.hasil', compact('konsultasi', 'kerusakan', 'solusi', 'gejalas'));
    }
}
