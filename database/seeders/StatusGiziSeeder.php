<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusGiziSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Specify the anak_id you want to insert the status_gizi for
        $specificAnakId = 1013;

        // Check if the anak_id already has a status_gizi
        $existingStatusGizi = DB::table('status_gizi')->where('anak_id', $specificAnakId)->first();

        if (!$existingStatusGizi) {
            // Insert a new status_gizi record for this anak_id
            DB::table('status_gizi')->insert([
                'anak_id' => $specificAnakId,
                'TB/U' => 'Sangat pendek',
                'BB/U' => 'Berat badan kurang',
                'BB/PB' => 'Gizi baik',
                'tindakan' => 'Rujuk ke rumah sakit untuk evaluasi stunting oleh Dokter Spesialis Anak',
                'berat_badan' => 5, 
                'tinggi_badan' => 55, 
                'tanggal_periksa' => Carbon::now('Asia/Jakarta'),
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }
    }
}

