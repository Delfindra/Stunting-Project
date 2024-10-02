@extends('layout/navbar')

@section('title', 'Cek Status Gizi')

@section('konten')
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="row" style="display: flex; margin-bottom: 20px;">

      <!-- Detail Data Panel -->
      <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="x_panel" style="display: flex; flex-direction: column; height: 100%;">
          <div class="x_title">
            <h2>Detail Data</h2>
            <!-- Tabel tersembunyi untuk detail data yang akan di-export ke PDF -->
              <div style="display: none;">
                <table id="detail-table">
                    <tbody>
                        <tr>
                            <td>Nama:</td>
                            <td>{{ $anak->nama_anak }}</td>
                        </tr>
                        <tr>
                          <td>NIK:</td>
                          <td>{{ $anak->nik }}</td>
                        </tr>
                        <tr>
                            <td>Umur:</td>
                            <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }} bulan</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir:</td>
                            <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir:</td>
                            <td>{{ $anak->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin:</td>
                            <td>{{ $anak->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <td>Alamat:</td>
                            <td>{{ $anak->detail_alamat }}, {{ $anak->kecamatan }}</td>
                        </tr>
                    </tbody>
                </table>
              </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="flex: 1;">
            <div class="form-group">
              <label for="name">Nama:</label> <span style="font-weight: normal;">{{ $anak->nama_anak }}
            </div>
            <div class="form-group">
              <label for="name">NIK:</label> <span style="font-weight: normal;">{{ $anak->nik }}
            </div>
            <div class="form-group">
              <label for="age">Umur:</label> 
                <span style="font-weight: normal;">
                  @php
                  $tanggalLahir = \Carbon\Carbon::parse($anak->tanggal_lahir);
                  $sekarang = \Carbon\Carbon::now();
                  $selisih = $tanggalLahir->diff($sekarang);
                  $tahun = $selisih->y;
                  $bulan = $selisih->m;
                  $hari = $selisih->d;
                  @endphp
                  {{ $tahun }} tahun - {{ $bulan }} bulan - {{ $hari }} hari
                </span>
            </div>
            <div class="form-group">
              <label for="birthdate">Tanggal Lahir:</label> <span style="font-weight: normal;">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</span>
            </div>
            <div class="form-group">
              <label for="birthplace">Tempat Lahir:</label> <span style="font-weight: normal;">{{ $anak->tempat_lahir }}</span>
            </div>
            <div class="form-group">
              <label for="gender">Jenis Kelamin:</label> <span style="font-weight: normal;">{{ $anak->jenis_kelamin}}</span>
            </div>
            <div class="form-group">
              <label for="address">Alamat:</label> <span style="font-weight: normal;">{{ $anak->detail_alamat }}, {{ $anak->kecamatan }}</span>
            </div>
          </div>
        </div>
      </div>

<!-- Riwayat Pemeriksaan Panel -->
<div class="col-md-9 col-sm-9 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Riwayat Pemeriksaan</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <button id="export-csv" class="btn-sm btn-primary" data-nama-anak="{{ $anak->nama_anak }}">Export to CSV</button>
      <button id="export-excel" class="btn-sm btn-primary" data-nama-anak="{{ $anak->nama_anak }}">Export to Excel</button>
      <button id="export-pdf" class="btn-sm btn-primary" data-nama-anak="{{ $anak->nama_anak }}">Export to PDF</button>       
      <!-- Wrap table with .table-responsive -->
      <div class="table-responsive">
        <table id="datatable-riwayat" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Waktu Pemeriksaan</th>
              <th>Umur (saat pemeriksaan)</th>
              <th>Berat badan (Kg)</th>
              <th>Tinggi badan (Cm)</th>
              <th>BB/U</th>
              <th>TB/U</th>
              <th>BB/PB</th>
              <th>ZScore BB/U</th>
              <th>ZScore TB/U</th>
              <th>ZScore BB/PB</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($anak->allGiziRecords as $gizi)
            <tr>
                <td>{{ \Carbon\Carbon::parse($gizi->tanggal_periksa)->translatedFormat("l jS F Y") }}</td>
                <td>
                    @php
                    $tanggalLahir = \Carbon\Carbon::parse($anak->tanggal_lahir);
                    $tanggalPeriksa = \Carbon\Carbon::parse($gizi->tanggal_periksa);
                    $selisih = $tanggalLahir->diff($tanggalPeriksa);
                    $tahun = $selisih->y;
                    $bulan = $selisih->m;
                    $hari = $selisih->d;
                    @endphp
                    {{ $tahun }} tahun - {{ $bulan }} bulan - {{ $hari }} hari
                </td>
                <td>{{ $gizi->berat_badan }}</td>
                <td>{{ $gizi->tinggi_badan }}</td>
                <td>{{ $gizi['BB/U'] }}</td>
                <td>{{ $gizi['TB/U'] }}</td>
                <td>{{ $gizi['BB/PB'] }}</td>
                <td>{{ $gizi->z_score_bbu }}</td>
                <td>{{ $gizi->z_score_tbu }}</td>
                <td>{{ $gizi->z_score_bbpb }}</td>
                <td>{{ $gizi->tindakan }}</td>
            </tr>
            @endforeach
          </tbody>          
        </table>
      </div>
    </div>
  </div>
</div>

    </div>

      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cek Status Gizi </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="dashboard-widget-content">
                      <!-- //form cek status gizi berisi Umur, berat badan, tinggi badan -->
                      <div class="x_content">
                        <form class="form-horizontal form-label-left" action="{{ route('storeGizi', ['id' => $anak->id]) }}" method="post">
                          @if(session('success'))
                          <div class="alert alert-success">
                              {{ session('success') }}
                          </div>
                          @endif
                          @if(session('error'))
                          <div class="alert alert-danger">
                              {{ session('error') }}
                          </div>
                          @endif
                          @csrf
                          <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal Pemeriksaan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="date" id="tanggal_periksa" name="tanggal_periksa" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Umur</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="umur" name="umur" required="required" class="form-control col-md-7 col-xs-12" 
                              value="{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now()) }} bulan" readonly>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Berat Badan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="berat_badan" name="berat_badan" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tinggi Badan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="tinggi_badan" name="tinggi_badan" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Faktor Determinan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <!-- Air Bersih -->
                              <label style="margin-top: 10px">Air bersih:</label><br>
                              <input type="radio" name="air-bersih" value="ada" required> Ada<br>
                              <input type="radio" name="air-bersih" value="tidak" required> Tidak ada<br>
                              <input type="radio" name="air-bersih" value="belum" required> Belum ada data <br><br>
                          
                              <!-- Jamban Sehat -->
                              <label>Jamban sehat:</label><br>
                              <input type="radio" name="jamban-sehat" value="ada" required> Ada<br>
                              <input type="radio" name="jamban-sehat" value="tidak" required> Tidak ada<br>
                              <input type="radio" name="jamban-sehat" value="belum" required> Belum ada data<br><br>
                          
                              <!-- Imunisasi -->
                              <label>Imunisasi:</label><br>
                              <input type="radio" name="imunisasi" value="ya" required> Ya<br>
                              <input type="radio" name="imunisasi" value="tidak" required> Tidak<br>
                              <input type="radio" name="imunisasi" value="belum" required> Belum ada data<br><br>
                          
                              <!-- Kecacingan -->
                              <label>Kecacingan:</label><br>
                              <input type="radio" name="kecacingan" value="ya" required> Ya<br>
                              <input type="radio" name="kecacingan" value="tidak" required> Tidak<br>
                              <input type="radio" name="kecacingan" value="belum" required> Belum ada data<br><br>
                          
                              <!-- Merokok (keluarga) -->
                              <label>Merokok (keluarga):</label><br>
                              <input type="radio" name="merokok-keluarga" value="ada" required> Ada<br>
                              <input type="radio" name="merokok-keluarga" value="tidak" required> Tidak ada<br>
                              <input type="radio" name="merokok-keluarga" value="belum" required> Belum ada data<br><br>
                          
                              <!-- Riwayat kehamilan ibu -->
                              <label>Riwayat kehamilan ibu:</label><br>
                              <input type="radio" name="riwayat-kehamilan-ibu" value="kek" required> KEK<br>
                              <input type="radio" name="riwayat-kehamilan-ibu" value="non-kek" required> Non KEK<br>
                              <input type="radio" name="riwayat-kehamilan-ibu" value="belum" required> Belum ada data<br><br>
                            </div>
                          </div>
                          
                          <div class="ln_solid"></div>
                          <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-9 col-md-offset-2">
                              <button type="submit" class="btn btn-primary">Cek Status Gizi</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>  
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        {{-- <div class="pull-right">
          Stunting
        </div> --}}
        {{-- <div class="clearfix"></div> --}}
      </footer>
      <!-- /footer content -->

<!-- Initialize the DataTable for Riwayat Pemeriksaan -->
<script>
$(document).ready(function() {
    var table = $('#datatable-riwayat').DataTable({
        responsive: true, // Enable responsive extension
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        order: [[0, 'asc']],
        paging: true,
        searching: true
    });

    table.buttons().container()
        .appendTo('#datatable-riwayat_wrapper .col-md-6:eq(0)');
});
</script>

<script>
  // Script untuk memicu SweetAlert berdasarkan sesi Laravel
  window.onload = function() {
      @if(session('success'))
          Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: '{{ session('success') }}'
          })
      @elseif(session('error'))
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '{{ session('error') }}'
          })
      @endif
  }
</script>

<script>
  // Fungsi untuk mendapatkan tanggal dan waktu saat ini dalam format yang diinginkan
  function getFormattedDateTime() {
    var now = new Date();
    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0');
    var day = now.getDate().toString().padStart(2, '0');
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    return year + '-' + month + '-' + day + '_' + hours + minutes + seconds; // Format: YYYY-MM-DD_HHMMSS
  }

// Fungsi untuk menambahkan sheet Detail Data ke workbook Excel
function detailDataToSheet() {
    var wb = XLSX.utils.book_new();
    var ws_name = "Detail Data";
    var detailTableHtml = document.getElementById('detail-table').innerHTML;
    var ws = XLSX.utils.table_to_sheet(detailTableHtml, {raw: true});
    XLSX.utils.book_append_sheet(wb, ws, ws_name);
    return wb;
}

// Event Listener untuk mengekspor ke Excel
document.querySelector("#export-excel").addEventListener("click", function(event) {
    event.preventDefault();
    var namaAnak = this.getAttribute('data-nama-anak');
    var filename = namaAnak + '_RiwayatPemeriksaan_' + getFormattedDateTime() + '.xlsx';

    var wb = XLSX.utils.book_new(); // Membuat workbook baru

    // Tambahkan sheet Detail Data ke workbook
    var detailTable = document.getElementById('detail-table');
    if (detailTable) {
        var ws_detail = XLSX.utils.table_to_sheet(detailTable, {raw: true});
        XLSX.utils.book_append_sheet(wb, ws_detail, "Detail Data");
    }

    // Tambahkan sheet Riwayat Pemeriksaan ke workbook
    var riwayatTable = document.getElementById('datatable-riwayat');
    if (riwayatTable) {
        var ws_riwayat = XLSX.utils.table_to_sheet(riwayatTable, {raw: true});
        XLSX.utils.book_append_sheet(wb, ws_riwayat, "Riwayat Pemeriksaan");
    }

    // Tulis workbook
    XLSX.writeFile(wb, filename);
});

// Event Listener untuk mengekspor ke CSV
document.querySelector("#export-csv").addEventListener("click", function(event) {
    event.preventDefault();
    var namaAnak = this.getAttribute('data-nama-anak');
    var filename = namaAnak + '_RiwayatPemeriksaan_' + getFormattedDateTime() + '.csv';

    // Mengonversi tabel detail ke CSV
    var wsDetail = XLSX.utils.table_to_sheet(document.getElementById('detail-table'), {raw: true});
    var csvDetail = XLSX.utils.sheet_to_csv(wsDetail);

    // Mengonversi tabel riwayat pemeriksaan ke CSV
    var wsRiwayat = XLSX.utils.table_to_sheet(document.getElementById('datatable-riwayat'), {raw: true});
    var csvRiwayat = XLSX.utils.sheet_to_csv(wsRiwayat);

    // Menggabungkan kedua CSV dengan memisahkannya dengan baris baru
    var combinedCsv = csvDetail + "\r\n\r\n" + csvRiwayat; // Tambahkan dua baris kosong sebagai pemisah

    // Buat blob CSV dan simpan
    var csvBlob = new Blob([combinedCsv], {type: "text/csv;charset=utf-8;"});
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(csvBlob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // Fitur HTML5 download
            var url = URL.createObjectURL(csvBlob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
});

// Export to PDF Event Listener
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelector("#export-pdf").addEventListener("click", function (event) {
        event.preventDefault();
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const namaAnak = this.getAttribute('data-nama-anak'); // Ambil nama anak dari data atribut
        const formattedDateTime = getFormattedDateTime(); // Dapatkan tanggal dan waktu saat ini

        // Eksport tabel detail data
        doc.autoTable({
            html: '#detail-table',
            theme: 'striped',
            headStyles: { fillColor: [41, 128, 185] }, // Custom color for header
            margin: { top: 20 },
            styles: { overflow: 'linebreak' } // Adjust overflow to handle large content
        });
        doc.addPage(); // Tambah halaman baru untuk riwayat pemeriksaan

        // Eksport tabel riwayat pemeriksaan
        doc.autoTable({
            html: '#datatable-riwayat',
            theme: 'striped',
            headStyles: { fillColor: [41, 128, 185] }, // Custom color for header
            styles: { overflow: 'linebreak' } // Adjust overflow to handle large content
        });

        // Simpan PDF dengan nama file yang disesuaikan
        var filename = namaAnak + '_RiwayatPemeriksaan_' + formattedDateTime + '.pdf';
        doc.save(filename);
    });
});

</script>


@endsection

