<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataGizi extends Model
{
    use HasFactory;
    protected $table = "status_gizi";
    protected $fillable = ['anak_id', 'TB/U', 'BB/U', 'BB/PB', 'tindakan', 'berat_badan', 'tinggi_badan', 'z_score_bbu', 'z_score_tbu', 
    'z_score_bbpb', 'tanggal_periksa', 'airBersih', 'jambanSehat', 'imunisasi', 'kecacingan', 'merokok', 'riwayatKehamilan'];

    public function anak()
    {
        return $this->belongsTo(dataAnak::class);
    }
}
