<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('anak')->insert([
            'nama_anak' => 'HAFIZHAN AL LATHIF P',
            'nik' => '3310061812230001',
            'tanggal_lahir' => '2023-12-18',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Trucuk',
            'detail_alamat' => 'SABRANGLOR',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'RINDU SETIYOWATI',
            'nik' => '3310124468700003',
            'tanggal_lahir' => '2023-12-13',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Trucuk',
            'detail_alamat' => 'KRADENAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ANEZKA DESWITA PUTRI',
            'nik' => '3310164312230000',
            'tanggal_lahir' => '2023-12-3',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Delanggu',
            'detail_alamat' => 'SUKORAME',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'RASYA MUHAMMAD NIZAM',
            'nik' => '3310111211230002',
            'tanggal_lahir' => '2023-11-12',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Ceper',
            'detail_alamat' => 'KURUNG LOR',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'MOH ABDUL QODIR',
            'nik' => '3310801302238409',
            'tanggal_lahir' => '2023-02-13',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Kebonarum',
            'detail_alamat' => 'MENDEN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'AHZA MAHENDRA MUSTOFA',
            'nik' => '3310231111220001',
            'tanggal_lahir' => '2022-11-11',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Kalikotes',
            'detail_alamat' => 'MARANGAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'KRISNA AJI PRADANA',
            'nik' => '3310081208230001',
            'tanggal_lahir' => '2023-08-12',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Jogonalan',
            'detail_alamat' => 'PUCUNG',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'DENADA AIZHA MISHA',
            'nik' => '3310020207230003',
            'tanggal_lahir' => '2023-07-02',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Gantiwarno',
            'detail_alamat' => 'BRANJANGAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'RIZKY SYAHRIL RAMADAN',
            'nik' => '3310170904230002',
            'tanggal_lahir' => '2023-04-09',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Polanharjo',
            'detail_alamat' => 'MARGOREJO',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'SHAQUEENA ADIBA RAMADHANI',
            'nik' => '3310115404230001',
            'tanggal_lahir' => '2023-04-14',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Ceper',
            'detail_alamat' => 'PUTATAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'HAMMAS HAFIZUL AZMI',
            'nik' => '331010251122000',
            'tanggal_lahir' => '2022-11-25',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Karangnongko',
            'detail_alamat' => 'BALEARJO',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'YAYANG HANDIKA',
            'nik' => '3310060311220001',
            'tanggal_lahir' => '2022-11-03',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Trucuk',
            'detail_alamat' => 'NGRENGGODADI',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ALLIF MUHAMMAD FATHUR',
            'nik' => '331017131222000',
            'tanggal_lahir' => '2022-12-13',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Polanharjo',
            'detail_alamat' => 'GLAGAHKIDUL',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'BRIANA PUTRI R',
            'nik' => '3310055611220001',
            'tanggal_lahir' => '2022-11-16',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Cawas',
            'detail_alamat' => 'GADINGAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'NAFESSHA ANINDITA',
            'nik' => '3310057010220001',
            'tanggal_lahir' => '2022-10-20',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Cawas',
            'detail_alamat' => 'JETAKAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ANTARES RAMA ALKHASAN',
            'nik' => '3310050411220001',
            'tanggal_lahir' => '2022-11-04',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Cawas',
            'detail_alamat' => 'GLAYAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'NAURA SEPTIANI',
            'nik' => '331005909220001',
            'tanggal_lahir' => '2022-09-19',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Cawas',
            'detail_alamat' => 'NAMENGAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'JIONATHAN PUTRA WARSONO',
            'nik' => '3310111704230001',
            'tanggal_lahir' => '2023-04-17',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Ceper',
            'detail_alamat' => 'KLEGEN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'AZZAHRA SARAH AGUSTIN',
            'nik' => '3310027008220001',
            'tanggal_lahir' => '2022-08-30',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Gantiwarno',
            'detail_alamat' => 'JETAK',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ALBARA KALIF DEVANDRA',
            'nik' => '3310123108230001',
            'tanggal_lahir' => '2023-08-31',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Pedan',
            'detail_alamat' => 'DUKUH',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ZAIFA FATHIYA ABIDAH',
            'nik' => '3310126411220001',
            'tanggal_lahir' => '2022-11-24',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Pedan',
            'detail_alamat' => 'DEWAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ARKHA SETIYAWAN',
            'nik' => '3310070306220002',
            'tanggal_lahir' => '2022-06-03',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Kebonarum',
            'detail_alamat' => 'GONDANG',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'ALENNA MESHWA ALBIRU',
            'nik' => '3310055905220002',
            'tanggal_lahir' => '2022-05-19',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Cawas',
            'detail_alamat' => 'SEWAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'RAKA ADITYA ARHAN',
            'nik' => '3310201905220002',
            'tanggal_lahir' => '2022-05-17',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Jatinom',
            'detail_alamat' => 'SOCOWETAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'NADEVA NAURA AZKIA',
            'nik' => '3310006207226738',
            'tanggal_lahir' => '2022-07-22',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Karanganom',
            'detail_alamat' => 'SUMBEREJO',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'KENZO ALDEFARO',
            'nik' => '3310070404210001',
            'tanggal_lahir' => '2021-04-04',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Laki-Laki',
            'kecamatan' => 'Kebonarum',
            'detail_alamat' => 'SAMBENG',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'SILVIA IRVA AZALEA',
            'nik' => '3310165102100002',
            'tanggal_lahir' => '2021-10-10',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Delanggu',
            'detail_alamat' => 'PACARAN',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);

        DB::table('anak')->insert([
            'nama_anak' => 'SELVIA KYARA ANJANI',
            'nik' => '3310214706210001',
            'tanggal_lahir' => '2021-06-07',
            'tempat_lahir' => 'Klaten',
            'jenis_kelamin' => 'Perempuan',
            'kecamatan' => 'Kemalang',
            'detail_alamat' => 'CANDIREJO',
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);
    }
}



// php artisan db:seed --class=AnakSeeder
