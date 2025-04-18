<?php
// app/Services/ForwardChainingService.php
namespace App\Services;

use App\Models\Aturan;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\Solusi;
use Illuminate\Support\Collection;

class ForwardChainingService
{
    /**
     * Melakukan diagnosa kerusakan berdasarkan gejala yang dipilih
     * menggunakan metode forward chaining
     *
     * @param array $selectedGejalaIds
     * @return array|null
     */
    public function diagnose(array $selectedGejalaIds)
    {
        // Ambil semua aturan (rules) dari database
        $aturans = Aturan::with(['kerusakan', 'gejalas'])->get();

        // Inisialisasi array hasil kecocokan
        $matchingScores = [];

        // Evaluasi setiap aturan
        foreach ($aturans as $aturan) {
            // Ambil semua gejala dalam aturan
            $gejalaIdsInRule = $aturan->gejalas->pluck('id')->toArray();

            // Hitung jumlah gejala yang cocok dengan input
            $matchCount = count(array_intersect($gejalaIdsInRule, $selectedGejalaIds));

            // Hitung total gejala dalam aturan
            $totalRuleGejalas = count($gejalaIdsInRule);

            // Jika semua gejala dalam aturan ada dalam input,
            // maka aturan ini cocok
            if ($matchCount == $totalRuleGejalas && $totalRuleGejalas > 0) {
                // Tambahkan ke daftar kecocokan dengan skor kecocokan
                $matchingScores[$aturan->id] = [
                    'aturan' => $aturan,
                    'score' => $matchCount / count($selectedGejalaIds),
                ];
            }
        }

        // Jika tidak ada aturan yang cocok
        if (empty($matchingScores)) {
            return null;
        }

        // Ambil aturan dengan skor kecocokan tertinggi
        $bestMatch = collect($matchingScores)->sortByDesc(function ($item) {
            return $item['score'];
        })->first();

        // Ambil kerusakan dan solusi
        $kerusakan = $bestMatch['aturan']->kerusakan;
        $solusi = Solusi::where('kerusakan_id', $kerusakan->id)->first();

        return [
            'kerusakan' => $kerusakan,
            'solusi' => $solusi,
        ];
    }
}
