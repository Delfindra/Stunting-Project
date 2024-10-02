<?php

namespace App\Http\Controllers;
use App\Models\dataAnak;
use App\Models\dataGizi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SebaranController extends Controller
{
    public function index()
    {
        $StatusGiziTerbaru = $this->getLatestCheckup();
        $faktorDeterminan = $this->fetchFaktorDeterminan($StatusGiziTerbaru);
        $kecamatanStats = $this->fetchKecamatanStats($StatusGiziTerbaru);  
        $intervensiPerKecamatan = $this->fetchIntervensi($StatusGiziTerbaru);
        $chartData = $this->prepareChartData($kecamatanStats, $faktorDeterminan);
        $dataTrenStatusGizi = $this->getTrenStatusGizi($StatusGiziTerbaru);
        $totalAnak = $this->countTotalAnak();

        $totalStunting = array_sum($chartData['stuntingData']);
        $totalGiziBuruk = array_sum($chartData['giziBurukData']);
        $totalUnderweight = array_sum($chartData['underweightData']);

        $kecamatanLabels = $chartData['kecamatanLabels'];
        $stuntingData = $chartData['stuntingData'];
        $giziBurukData = $chartData['giziBurukData'];
        $underweightData = $chartData['underweightData'];

        $airBersihData = $chartData['airBersihData'];
        $jambanSehatData = $chartData['jambanSehatData'];
        $imunisasiData = $chartData['imunisasiData'];
        $kecacinganData = $chartData['kecacinganData'];
        $merokokData = $chartData['merokokData'];
        $riwayatKehamilanData = $chartData['riwayatKehamilanData'];

        $intervensiLabels = $intervensiPerKecamatan->pluck('kecamatan')->toArray();
        $intervensiRujukKeRumahSakit = $intervensiPerKecamatan->pluck('rujuk_ke_rumah_sakit')->toArray();
        $intervensiPemberianPMT = $intervensiPerKecamatan->pluck('pemberian_pmt')->toArray();
        $intervensiPemberianEdukasi = $intervensiPerKecamatan->pluck('pemberian_edukasi')->toArray();

        $monthsYears = $this->getAvailableMonthsYears();

        return view('page.sebaranStatusGizi', compact(
            'kecamatanLabels', 'stuntingData', 'giziBurukData', 'underweightData',
            'airBersihData', 'jambanSehatData', 'imunisasiData', 'kecacinganData', 'merokokData',
            'riwayatKehamilanData', 'totalStunting', 'totalGiziBuruk', 'totalUnderweight', 'totalAnak', 
            'dataTrenStatusGizi', 'kecamatanStats', 'faktorDeterminan', 'intervensiLabels', 
            'intervensiRujukKeRumahSakit', 'intervensiPemberianPMT', 'intervensiPemberianEdukasi', 'monthsYears'
        ));
    }

    private function countTotalAnak()
    {
        return DB::table('anak')->count('id');
    }

    private function getAvailableMonthsYears()
    {
        return DB::table('status_gizi')
            ->select(DB::raw('YEAR(tanggal_periksa) as year, MONTH(tanggal_periksa) as month'))
            ->distinct()
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }

    private function getLatestCheckup()
    {
        return DB::table('status_gizi')
            ->select('anak_id', DB::raw('MAX(tanggal_periksa) as tanggal_periksa_terakhir'))
            ->groupBy('anak_id');
    }

    private function getLatestCheckupFiltered($year, $month)
    {
        $query = DB::table('status_gizi')
            ->select('anak_id', DB::raw('MAX(tanggal_periksa) as tanggal_periksa_terakhir'))
            ->groupBy('anak_id');

        if ($year && $month) {
            $query->whereYear('tanggal_periksa', $year)
                  ->whereMonth('tanggal_periksa', $month);
        }

        return $query;
    }

    private function fetchKecamatanStats($StatusGiziTerbaru)
    {
        return DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->join('status_gizi', function ($join) {
                $join->on('anak.id', '=', 'status_gizi.anak_id')
                    ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw("SUM(CASE WHEN status_gizi.`TB/U` IN ('Sangat pendek', 'pendek') THEN 1 ELSE 0 END) AS stunting"),
                DB::raw("SUM(CASE WHEN status_gizi.`BB/U` IN ('Berat badan sangat kurang', 'Berat badan kurang') THEN 1 ELSE 0 END) AS underweight"),
                DB::raw("SUM(CASE WHEN status_gizi.`BB/PB` = 'Gizi buruk' THEN 1 ELSE 0 END) AS gizi_buruk"),
                DB::raw("COUNT(status_gizi.anak_id) AS total_cases"),
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`TB/U` IN ('Sangat pendek', 'pendek') THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS stunting_percentage"),
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`BB/U` IN ('Berat badan sangat kurang', 'Berat badan kurang') THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS underweight_percentage"),
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`BB/PB` = 'Gizi buruk' THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS gizi_buruk_percentage")
            )
            ->groupBy('anak.kecamatan')
            ->get();
    }

    private function fetchKecamatanStatsFiltered($StatusGiziTerbaru)
    {
        $query = DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->join('status_gizi', function ($join) {
                $join->on('anak.id', '=', 'status_gizi.anak_id')
                     ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw("SUM(CASE WHEN status_gizi.`TB/U` IN ('Sangat pendek', 'pendek') THEN 1 ELSE 0 END) AS stunting"),
                DB::raw("SUM(CASE WHEN status_gizi.`BB/U` IN ('Berat badan sangat kurang', 'Berat badan kurang') THEN 1 ELSE 0 END) AS underweight"),
                DB::raw("SUM(CASE WHEN status_gizi.`BB/PB` = 'Gizi buruk' THEN 1 ELSE 0 END) AS gizi_buruk"),
                DB::raw("COUNT(status_gizi.anak_id) AS total_cases"))
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`TB/U` IN ('Sangat pendek', 'pendek') THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS stunting_percentage"),
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`BB/U` IN ('Berat badan sangat kurang', 'Berat badan kurang') THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS underweight_percentage"),
                // DB::raw("ROUND(SUM(CASE WHEN status_gizi.`BB/PB` = 'Gizi buruk' THEN 1 ELSE 0 END) / COUNT(status_gizi.anak_id) * 100, 2) AS gizi_buruk_percentage"))
            ->groupBy('anak.kecamatan');
        return $query->get();
    }

    private function fetchIntervensi($StatusGiziTerbaru)
    {
        $latestTindakanQuery = DB::table('status_gizi')
            ->select('anak_id', 'tindakan', DB::raw('MAX(tanggal_periksa) as tanggal_periksa_terakhir'))
            ->groupBy('anak_id', 'tindakan');

        return DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->joinSub($latestTindakanQuery, 'latest_tindakan', function ($join) {
                $join->on('anak.id', '=', 'latest_tindakan.anak_id')
                     ->on('status_gizi_terbaru.tanggal_periksa_terakhir', '=', 'latest_tindakan.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw("
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%rujuk ke rumah sakit%' THEN 1 ELSE 0 END) as rujuk_ke_rumah_sakit,
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%pmt%' THEN 1 ELSE 0 END) as pemberian_pmt,
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%berikan edukasi%' THEN 1 ELSE 0 END) as pemberian_edukasi
                    ")
            )
            ->groupBy('anak.kecamatan')
            ->get();
    }

    private function fetchIntervensiFiltered($StatusGiziTerbaru)
    {
        $latestTindakanQuery = DB::table('status_gizi')
            ->select('anak_id', 'tindakan', DB::raw('MAX(tanggal_periksa) as tanggal_periksa_terakhir'))
            ->groupBy('anak_id', 'tindakan');

        return DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->joinSub($latestTindakanQuery, 'latest_tindakan', function ($join) {
                $join->on('anak.id', '=', 'latest_tindakan.anak_id')
                     ->on('status_gizi_terbaru.tanggal_periksa_terakhir', '=', 'latest_tindakan.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw("
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%rujuk ke rumah sakit%' THEN 1 ELSE 0 END) as rujuk_ke_rumah_sakit,
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%pmt%' THEN 1 ELSE 0 END) as pemberian_pmt,
                    SUM(CASE WHEN latest_tindakan.tindakan LIKE '%berikan edukasi%' THEN 1 ELSE 0 END) as pemberian_edukasi
                    ")
            )
            ->groupBy('anak.kecamatan')
            ->get();
    }

    private function fetchFaktorDeterminan($StatusGiziTerbaru)
    {
        return DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->join('status_gizi', function ($join) {
                $join->on('anak.id', '=', 'status_gizi.anak_id')
                     ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw('SUM(CASE WHEN status_gizi.airBersih = "Tidak" THEN 1 ELSE 0 END) as airBersih'),
                DB::raw('SUM(CASE WHEN status_gizi.jambanSehat = "Tidak" THEN 1 ELSE 0 END) as jambanSehat'),
                DB::raw('SUM(CASE WHEN status_gizi.imunisasi = "Tidak" THEN 1 ELSE 0 END) as imunisasi'),
                DB::raw('SUM(CASE WHEN status_gizi.kecacingan = "Ya" THEN 1 ELSE 0 END) as kecacingan'),
                DB::raw('SUM(CASE WHEN status_gizi.merokok = "Ada" THEN 1 ELSE 0 END) as merokok'),
                DB::raw('SUM(CASE WHEN status_gizi.riwayatKehamilan = "KEK" THEN 1 ELSE 0 END) as riwayatKehamilan'))
            ->groupBy('anak.kecamatan')
            ->get();
    }

    private function fetchFaktorDeterminanFiltered($StatusGiziTerbaru)
    {
        $query = DB::table('anak')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('anak.id', '=', 'status_gizi_terbaru.anak_id');
            })
            ->join('status_gizi', function ($join) {
                $join->on('anak.id', '=', 'status_gizi.anak_id')
                     ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                'anak.kecamatan',
                DB::raw('SUM(CASE WHEN status_gizi.airBersih = "Tidak" THEN 1 ELSE 0 END) as airBersih'),
                DB::raw('SUM(CASE WHEN status_gizi.jambanSehat = "Tidak" THEN 1 ELSE 0 END) as jambanSehat'),
                DB::raw('SUM(CASE WHEN status_gizi.imunisasi = "Tidak" THEN 1 ELSE 0 END) as imunisasi'),
                DB::raw('SUM(CASE WHEN status_gizi.kecacingan = "Ya" THEN 1 ELSE 0 END) as kecacingan'),
                DB::raw('SUM(CASE WHEN status_gizi.merokok = "Ada" THEN 1 ELSE 0 END) as merokok'),
                DB::raw('SUM(CASE WHEN status_gizi.riwayatKehamilan = "KEK" THEN 1 ELSE 0 END) as riwayatKehamilan'))
            ->groupBy('anak.kecamatan');

        return $query->get();
    }

    private function getTrenStatusGizi($StatusGiziTerbaru)
    {
        $query = DB::table('status_gizi')
            ->join('anak', 'status_gizi.anak_id', '=', 'anak.id')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('status_gizi.anak_id', '=', 'status_gizi_terbaru.anak_id')
                     ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                DB::raw("TIMESTAMPDIFF(MONTH, anak.tanggal_lahir, status_gizi.tanggal_periksa) AS usia_bulan"),
                'status_gizi.BB/PB',
                DB::raw('MONTH(status_gizi.tanggal_periksa) as bulan')
            )
            ->whereBetween(DB::raw("TIMESTAMPDIFF(MONTH, anak.tanggal_lahir, status_gizi.tanggal_periksa)"), [0, 24])
            ->distinct();
    
        return $query->get()->groupBy('bulan')->map(function ($item) {
            return $item->groupBy('usia_bulan')->map(function ($groupedByUsia) {
                return $groupedByUsia->groupBy('BB/PB')->map->count();
            });
        });
    }   

    private function getTrenStatusGiziFiltered($StatusGiziTerbaru)
    {
        $query = DB::table('status_gizi')
            ->join('anak', 'status_gizi.anak_id', '=', 'anak.id')
            ->joinSub($StatusGiziTerbaru, 'status_gizi_terbaru', function ($join) {
                $join->on('status_gizi.anak_id', '=', 'status_gizi_terbaru.anak_id')
                     ->on('status_gizi.tanggal_periksa', '=', 'status_gizi_terbaru.tanggal_periksa_terakhir');
            })
            ->select(
                DB::raw("TIMESTAMPDIFF(MONTH, anak.tanggal_lahir, status_gizi.tanggal_periksa) AS usia_bulan"),
                'status_gizi.BB/PB',
                DB::raw('MONTH(status_gizi.tanggal_periksa) as bulan')
            )
            ->whereBetween(DB::raw("TIMESTAMPDIFF(MONTH, anak.tanggal_lahir, status_gizi.tanggal_periksa)"), [0, 24])
            ->distinct();

        return $query->get()->groupBy('bulan')->map(function ($item) {
            return $item->groupBy('usia_bulan')->map(function ($groupedByUsia) {
                return $groupedByUsia->groupBy('BB/PB')->map->count();
            });
        });
    }

   private function prepareChartData($kecamatanStats, $faktorDeterminan)
    {
        $kecamatanLabels = $kecamatanStats->pluck('kecamatan')->toArray();
        $stuntingData = $kecamatanStats->pluck('stunting')->toArray();
        $giziBurukData = $kecamatanStats->pluck('gizi_buruk')->toArray();
        $underweightData = $kecamatanStats->pluck('underweight')->toArray();

        $airBersihData = $faktorDeterminan->pluck('airBersih')->toArray();
        $jambanSehatData = $faktorDeterminan->pluck('jambanSehat')->toArray();
        $imunisasiData = $faktorDeterminan->pluck('imunisasi')->toArray();
        $kecacinganData = $faktorDeterminan->pluck('kecacingan')->toArray();
        $merokokData = $faktorDeterminan->pluck('merokok')->toArray();
        $riwayatKehamilanData = $faktorDeterminan->pluck('riwayatKehamilan')->toArray();

        return [
            'kecamatanLabels' => $kecamatanLabels,
            'stuntingData' => $stuntingData,
            'giziBurukData' => $giziBurukData,
            'underweightData' => $underweightData,
            'airBersihData' => $airBersihData,
            'jambanSehatData' => $jambanSehatData,
            'imunisasiData' => $imunisasiData,
            'kecacinganData' => $kecacinganData,
            'merokokData' => $merokokData,
            'riwayatKehamilanData' => $riwayatKehamilanData
        ];
    }

    public function getSebaranData(Request $request)
    {
        $monthYear = $request->query('monthYear');
        [$year, $month] = $monthYear ? explode('-', $monthYear) : [null, null];
    
        $StatusGiziTerbaru = $this->getLatestCheckupFiltered($year, $month);
        $faktorDeterminan = $this->fetchFaktorDeterminanFiltered($StatusGiziTerbaru);
        $kecamatanStats = $this->fetchKecamatanStatsFiltered($StatusGiziTerbaru);
        $intervensiPerKecamatan = $this->fetchIntervensiFiltered($StatusGiziTerbaru);
        $dataTrenStatusGizi = $this->getTrenStatusGiziFiltered($StatusGiziTerbaru);
    
        $chartData = $this->prepareChartData($kecamatanStats, $faktorDeterminan);
    
        return response()->json([
            'kecamatanLabels' => $chartData['kecamatanLabels'],
            'stuntingData' => $chartData['stuntingData'],
            'giziBurukData' => $chartData['giziBurukData'],
            'underweightData' => $chartData['underweightData'],
            'airBersihData' => $chartData['airBersihData'],
            'jambanSehatData' => $chartData['jambanSehatData'],
            'imunisasiData' => $chartData['imunisasiData'],
            'kecacinganData' => $chartData['kecacinganData'],
            'merokokData' => $chartData['merokokData'],
            'riwayatKehamilanData' => $chartData['riwayatKehamilanData'],
            'intervensiLabels' => $intervensiPerKecamatan->pluck('kecamatan')->toArray(),
            'intervensiRujukKeRumahSakit' => $intervensiPerKecamatan->pluck('rujuk_ke_rumah_sakit')->toArray(),
            'intervensiPemberianPMT' => $intervensiPerKecamatan->pluck('pemberian_pmt')->toArray(),
            'intervensiPemberianEdukasi' => $intervensiPerKecamatan->pluck('pemberian_edukasi')->toArray(),
            'trenStatusGiziLabels' => range(1, 12),
            'trenStatusGiziDatasets' => $this->prepareTrenStatusGiziDatasets($dataTrenStatusGizi)
        ]);
    }  

    private function prepareTrenStatusGiziDatasets($dataTrenStatusGizi)
    {
        $datasets = [
            'Gizi buruk' => ['label' => 'Gizi buruk', 'data' => array_fill(0, 24, 0), 'borderColor' => 'cyan', 'fill' => false, 'tension' => 0.1],
            'Gizi kurang' => ['label' => 'Gizi kurang', 'data' => array_fill(0, 24, 0), 'borderColor' => 'magenta', 'fill' => false, 'tension' => 0.1],
            'Risiko gizi lebih' => ['label' => 'Risiko gizi lebih', 'data' => array_fill(0, 24, 0), 'borderColor' => 'blue', 'fill' => false, 'tension' => 0.1],
            'Gizi baik' => ['label' => 'Gizi baik', 'data' => array_fill(0, 24, 0), 'borderColor' => 'green', 'fill' => false, 'tension' => 0.1],
            'Obesitas' => ['label' => 'Obesitas', 'data' => array_fill(0, 24, 0), 'borderColor' => 'red', 'fill' => false, 'tension' => 0.1]
        ];
    
        foreach ($dataTrenStatusGizi as $bulan => $dataByMonth) {
            $monthIndex = (int)$bulan - 1;
            foreach ($dataByMonth as $usia_bulan => $dataByUsia) {
                foreach ($dataByUsia as $status_gizi => $count) {
                    if (isset($datasets[$status_gizi])) {
                        $datasets[$status_gizi]['data'][$monthIndex] += $count;
                    }
                }
            }
        }
        return array_values($datasets);
    }
}





