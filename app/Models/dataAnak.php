<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataAnak extends Model
{
    use HasFactory;
    protected $table = "anak";
    protected $fillable = ['nik','nama_anak', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'kecamatan', 'detail_alamat'];

    public function gizi()
    {
        return $this->hasOne(dataGizi::class, 'anak_id')->latest('created_at');
    }

     // New relationship to get all gizi records
    public function allGiziRecords()
    {
        return $this->hasMany(dataGizi::class, 'anak_id');
    }
    
}




