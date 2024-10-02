<?php

namespace App\Http\Controllers;

use App\Models\dataAnak;
use App\Models\dataGizi;
use App\Models\ruleBBPBMen;
use App\Models\ruleBBUMen;
use App\Models\ruleTBUMen;
use App\Models\ruleBBPBWomen;
use App\Models\ruleBBUWomen;
use App\Models\ruleTBUWomen;


use Illuminate\Http\Request;
use Carbon\Carbon;

Carbon::setLocale('id');

class cekStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = dataAnak::with('allGiziRecords')->get();
        // return view('page/tambahData', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request, $id)
     {
         // Mencari instansi Anak berdasarkan ID
         $anak = dataAnak::find($id);
     
         // Memeriksa apakah instansi Anak ditemukan
         if (!$anak) {
             return redirect()->back()->with('error', 'Data Anak tidak ditemukan');
         }
     
         $jenisKelamin = $anak->jenis_kelamin; 
         $tanggalPeriksa = Carbon::parse($request->tanggal_periksa);
         $tanggalLahir = Carbon::parse($anak->tanggal_lahir);
     
         // Exception jika tanggal pemeriksaan lebih dari tanggal saat ini
         if ($tanggalPeriksa->isFuture()) {
             return redirect()->back()->with('error', 'Tanggal pemeriksaan tidak boleh lebih dari tanggal saat ini!');
         }
     
         // Exception jika tanggal pemeriksaan kurang dari tanggal lahir
         if ($tanggalPeriksa->lt($tanggalLahir)) {
             return redirect()->back()->with('error', 'Tanggal pemeriksaan tidak boleh kurang dari tanggal lahir!');
         }
     
         // Menghitung umur dalam bulan berdasarkan tanggal periksa
         $umur = $tanggalLahir->diffInMonths($tanggalPeriksa);
     
         // Cek jika umur anak lebih dari 24 bulan
         if ($umur < 0 || $umur > 24) {
             return redirect()->back()->with('error', 'Umur anak harus antara 0 sampai 24 bulan!');
         }
     
         $beratBadan = $request->berat_badan;
         $tinggiBadan = $request->tinggi_badan;
     
         // Cek dan hitung skor Z untuk TB/U berdasarkan jenis kelamin
         if ($jenisKelamin == 'Laki-Laki') {
             $ruleTBU = ruleTBUMen::where('age_months', $umur)->firstOrFail();
         } else {
             $ruleTBU = ruleTBUWomen::where('age_months', $umur)->firstOrFail();
         }
         $zScoreTBU = $this->calculateZScore($tinggiBadan, $ruleTBU->median, $ruleTBU->minus_one_sd, $ruleTBU->plus_one_sd);
         $statusTBU = $this->determineTBUStatus($zScoreTBU);
     
         // Cek dan hitung skor Z untuk BB/U berdasarkan jenis kelamin
         if ($jenisKelamin == 'Laki-Laki') {
             $ruleBBU = ruleBBUMen::where('age_months', $umur)->firstOrFail();
         } else {
             $ruleBBU = ruleBBUWomen::where('age_months', $umur)->firstOrFail();
         }
         $zScoreBBU = $this->calculateZScore($beratBadan, $ruleBBU->median, $ruleBBU->minus_one_sd, $ruleBBU->plus_one_sd);
         $statusBBU = $this->determineBBUStatus($zScoreBBU);
     
         // Cek dan hitung skor Z untuk BB/PB berdasarkan jenis kelamin
         if ($jenisKelamin == 'Laki-Laki') {
             $ruleBBPB = ruleBBPBMen::where('length_cm', $tinggiBadan)->firstOrFail();
         } else {
             $ruleBBPB = ruleBBPBWomen::where('length_cm', $tinggiBadan)->firstOrFail();
         }
         $zScoreBBPB = $this->calculateZScore($beratBadan, $ruleBBPB->median, $ruleBBPB->minus_one_sd, $ruleBBPB->plus_one_sd);
         $statusBBPB = $this->determineBBPBStatus($zScoreBBPB);
     
         $airBersih = $request->input('air-bersih');
         $jambanSehat = $request->input('jamban-sehat');
         $imunisasi = $request->input('imunisasi');
         $kecacingan = $request->input('kecacingan');
         $merokok = $request->input('merokok-keluarga');
         $riwayatKehamilan = $request->input('riwayat-kehamilan-ibu');
     
         // Mendapatkan tanggal periksa terakhir dari dataGizi
         $tanggalPeriksaTerakhir = dataGizi::where('anak_id', $anak->id)->orderBy('tanggal_periksa', 'desc')->first();
         $selisihHari = $tanggalPeriksaTerakhir ? Carbon::parse($tanggalPeriksaTerakhir->tanggal_periksa)->diffInDays($tanggalPeriksa) : null;

         // Determine action based on nutritional status
         $tindakan = $this->determineTindakan($zScoreBBU, $zScoreTBU, $zScoreBBPB, $airBersih, $jambanSehat, $imunisasi, $kecacingan, $merokok, $riwayatKehamilan, $selisihHari);

         // Simpan data status gizi
         $dataGizi = new dataGizi([
             'anak_id' => $anak->id,
             'BB/U' => $statusBBU,
             'TB/U' => $statusTBU,
             'BB/PB' => $statusBBPB,
             'tindakan' => $tindakan,
             'berat_badan' => $beratBadan,
             'tinggi_badan' => $tinggiBadan,
             'z_score_bbu' => $zScoreBBU,
             'z_score_tbu' => $zScoreTBU,
             'z_score_bbpb' => $zScoreBBPB,
             'tanggal_periksa' => $tanggalPeriksa,
             'airBersih' => $airBersih,
             'jambanSehat' => $jambanSehat,
             'imunisasi' => $imunisasi,
             'kecacingan' => $kecacingan,
             'merokok' => $merokok,
             'riwayatKehamilan' => $riwayatKehamilan,
         ]);
     
         $dataGizi->save();
     
         // Redirect dengan pesan sukses
         return redirect()->back()->with('success', 'Data berhasil disimpan.');
     }
     
    protected function calculateZScore($value, $median, $sd_minus_one, $sd_plus_one)
    {
        // Cek untuk memastikan bahwa standar deviasi tidak nol
        if ($sd_plus_one == $median || $sd_minus_one == $median) {
            throw new \Exception('Standard deviation tidak boleh sama dengan median.');
        }
        
        $sdReference = $value >= $median ? ($sd_plus_one - $median) : ($median - $sd_minus_one);
        
        // Cek untuk menghindari pembagian dengan nol
        if ($sdReference == 0) {
            throw new \Exception('Nilai simpang baku rujukan tidak boleh nol.');
        }
    
        $zScore = ($value - $median) / $sdReference;
        return $zScore;
    }
    
    protected function determineTBUStatus($zScore)
    {
        if ($zScore < -3) {
            return 'Sangat pendek';
        } elseif ($zScore >= -3 && $zScore <= -2) {
            return 'Pendek';
        } elseif ($zScore > -2 && $zScore <= 3) {
            return 'Normal';
        } else {
            return 'Tinggi';
        }
    }

    protected function determineBBUStatus($zScore)
    {
        if ($zScore < -3) {
            return 'Berat badan sangat kurang';
        } elseif ($zScore >= -3 && $zScore < -2) {
            return 'Berat badan kurang';
        } elseif ($zScore >= -2 && $zScore < 1) {
            return 'Berat badan normal';
        } elseif ($zScore >= 1 && $zScore < 2) { 
            return 'Risiko Berat badan lebih';
        } else {
            return 'Berat badan lebih'; 
        }
    }  

    protected function determineBBPBStatus($zScore)
    {
        if ($zScore <= -3) {
            return 'Gizi buruk';
        } elseif ($zScore > -3 && $zScore < -2) {
            return 'Gizi kurang';
        } elseif ($zScore >= -2 && $zScore <= 1) { 
            return 'Gizi baik';
        } elseif ($zScore > 1 && $zScore < 2) { 
            return 'Risiko gizi lebih';
        } elseif ($zScore >= 2 && $zScore < 3) { 
            return 'Gizi lebih';
        } elseif ($zScore >= 3) { 
            return 'Obesitas';
        }
    }   

    protected function determineTindakan($zScoreBBU, $zScoreTBU, $zScoreBBPB, $airBersih, $jambanSehat, $imunisasi, $kecacingan, $merokok, $riwayatKehamilan, $selisihHari)
    {
        // Konversi input ke boolean
        $faktorDeterminan = [
            'air-bersih' => $airBersih === 'Tidak',
            'jamban-sehat' => $jambanSehat === 'Tidak',
            'imunisasi' => $imunisasi === 'Tidak',
            'kecacingan' => $kecacingan === 'Ya',
            'merokok-keluarga' => $merokok === 'Ada',
            'riwayat-kehamilan-ibu' => $riwayatKehamilan === 'KEK',
        ];
    
        // Cek jika ada setidaknya satu faktor determinan yang true
        $adaFaktorDeterminan = in_array(true, $faktorDeterminan);
    
        // Menentukan status gizi
        $statusBBU = $this->determineBBUStatus($zScoreBBU);
        $statusTBU = $this->determineTBUStatus($zScoreTBU);
        $statusBBPB = $this->determineBBPBStatus($zScoreBBPB);

        // Rule 1: TBU - Sangat pendek atau Pendek 
        if ($statusTBU === 'Sangat pendek' || $statusTBU === 'Pendek') {
            if ($adaFaktorDeterminan) {
                return 'Rujuk ke rumah sakit untuk dilakukan konfirmasi terhadap red flag yang menyebabkan stunting oleh Dokter Spesialis Anak';
            } else {
                return 'Rujuk ke rumah sakit untuk dilakukan konfirmasi terhadap red flag yang menyebabkan stunting oleh Dokter Spesialis Anak';
            }
        }
    
        // Rule 2: BB/PB - Gizi Buruk
        if ($statusBBPB === 'Gizi buruk') {
            if ($adaFaktorDeterminan && $selisihHari === 0) {
                return 'Berikan F75 selama 3 hari, F100 selama 11 hari dan PMT (Pemberian Makanan Tambahan)';
            } elseif ($selisihHari > 0 && $selisihHari <= 14) {
                return 'Rujuk ke rumah sakit untuk penanganan lebih lanjut';
            } else {
                return 'Berikan F75 selama 3 hari, F100 selama 11 hari dan PMT (Pemberian Makanan Tambahan)';
            }
        }

        // Rule 3: BB/PB - Gizi kurang
        if ($statusBBPB === 'Gizi kurang') {
            if ($adaFaktorDeterminan) {
                return 'Berikan PMT (Pemberian Makanan Tambahan) berbasis bahan pangan lokal yang kaya akan protein hewani selama 90 hari';
            } else {
                return 'Berikan PMT (Pemberian Makanan Tambahan) berbasis bahan pangan lokal yang kaya akan protein hewani selama 90 hari';
            }
        }

        // Rule 4: BB/U - Berat badan sangat kurang 
        if ($statusBBU === 'Berat badan sangat kurang' || $statusBBU === 'Berat badan kurang') {
            if ($adaFaktorDeterminan && $selisihHari === 0) {
                return 'Berikan PMT (Pemberian Makanan Tambahan) berbasis bahan pangan lokal yang kaya akan protein hewani selama 14 hari';
            } elseif ($selisihHari > 0 && $selisihHari <= 14) {
                return 'Rujuk ke rumah sakit untuk penanganan lebih lanjut';
            } else {
                return 'Berikan PMT (Pemberian Makanan Tambahan) berbasis bahan pangan lokal yang kaya akan protein hewani selama 14 hari';
            }
        }

        // Rule 5: Skor Z Normal tanpa faktor determinan
        if ($statusBBU === 'Normal' && $statusTBU === 'Normal' && $statusBBPB === 'Normal') {
            return 'Lakukan pemantauan status gizi dan pemberian nutrisi sesuai kebutuhan';
        }
    
        // Rule 6: BB/PB - Risiko gizi lebih atau Gizi lebih
        if ($statusBBU === 'Risiko berat badan lebih' || $statusBBU === 'Berat badan lebih' || 
            $statusBBPB === 'Berisiko gizi lebih' || $statusBBPB === 'Gizi lebih' || $statusBBPB === 'Obesitas') {
            return 'Berikan edukasi nutrisi kepada orang tua tentang pentingnya pola makan sehat dan seimbang untuk anak
            dan lakukan intervensi gizi serta monitor pertumbuhan';
        }
    
        // Default action
        return 'Tidak ada intervensi khusus yang diperlukan, lanjutkan pemantauan';
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anak = dataAnak::findOrFail($id);
        return view('page/cekStatus', compact('anak'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}

