@extends('layout/navbar')

@section('title', 'Status Gizi')

@section('konten')
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Status Gizi </h3>
          </div>
        </div>
        <div class="clearfix"></div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Daftar Data</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="x_content">
                  <a href="/tambahData">
                    <button class="btn-sm btn-success">
                      <i class="fa fa-plus fa-fw"></i>
                      Tambah Data
                    </button>
                  </a>
                    <button id="export-csv" class="btn-sm btn-primary">Export to CSV</button>
                    <button id="export-excel" class="btn-sm btn-primary">Export to Excel</button>
                    <button id="export-pdf" class="btn-sm btn-primary">Export to PDF</button>                    
                  
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Waktu Pemeriksaan</th>
                        <th>Tindakan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $anak)
                      <tr>
                        <td>{{ $anak->id }}</td>
                        <td>{{ $anak->nama_anak }}</td>
                        <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                        <td>{{ $anak->detail_alamat }}, {{ $anak->kecamatan }}</td>
                        <td>{{ optional($anak->gizi)->tanggal_periksa ? \Carbon\Carbon::parse($anak->gizi->tanggal_periksa)->translatedFormat("l, jS F Y") : '-' }}</td>
                        <td>{{ optional($anak->gizi)->tindakan ?: '-' }}</td>
                        <td>
                          <a href="{{ route('cekStatus.show', $anak->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Detail Data</a>
                          <a href="javascript:void(0);" onclick="editData({{ $anak->id }})" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Ubah Data</a>
                          <a href="javascript:void(0);" class="btn btn-danger btn-xs delete-trigger" data-id="{{ $anak->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus Data</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form id="editForm" class="form-horizontal form-label-left" method="POST" action="{{ route('dataAnak.update', $anak->id) }}">
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
                @method('PUT')
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_anak" class="form-control col-md-7 col-xs-12" name="nama_anak" value="{{$anak->nama_anak}}" required="required" type="text">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Tempat Lahir <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{$anak->tempat_lahir}}" required="required" type="text" 
                    class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Tanggal Lahir <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{$anak->tanggal_lahir}}" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Jenis Kelamin <span class="required"></span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="{{$anak->jenis_kelamin}}">
                      <option value="" disabled selected class="placeholder">Pilih Jenis Kelamin</option>
                      <option>Laki-Laki</option>
                      <option>Perempuan</option>
                    </select>
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Kecamatan <span class="required"></span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" id="kecamatan" name="kecamatan" value="{{$anak->kecamatan}}">
                      <option value="" disabled selected class="placeholder">Pilih Kecamatan</option>
                      <option>Bayat</option>
                      <option>Cawas</option>
                      <option>Ceper</option>
                      <option>Delanggu</option>
                      <option>Gantiwarno</option>
                      <option>Jatinom</option>
                      <option>Jogonalan</option>
                      <option>Kalikotes</option>
                      <option>Karanganom</option>
                      <option>Karangdowo</option>
                      <option>Kemalang</option>
                      <option>Klaten Selatan</option>
                      <option>Klaten Tengah</option>
                      <option>Klaten Utara</option>
                      <option>Manisrenggo</option>
                      <option>Ngawen</option>
                      <option>Pedan</option>
                      <option>Polanharjo</option>
                      <option>Prambanan</option>
                      <option>Trucuk</option>
                      <option>Tulung</option>
                      <option>Wedi</option>
                      <option>Wonosari</option>
                    </select>
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Detail Alamat <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="textarea" required="required" id="detail_alamat" name="detail_alamat" value="{{$anak->detail_alamat}}" class="form-control col-md-7 col-xs-12"></textarea>
                  </div>
                </div>
                
                <div class="ln_solid"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-info" form="editForm">Edit</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Delete Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah anda yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" id="deleteId">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Hapus Data</button>
          </form>
        </div>
      </div>
     </div>
    </div>

      <!-- footer content -->
      <footer>
        <div class="pull-right"> 
          {{-- Stunting --}}
        </div> 
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>

  <script>
    $(document).ready(function() {
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            order: [[0, 'asc']], // Default sort column (0-indexed) and sort direction
            paging: true, // Enable pagination
            searching: true, // Enable searching
            pageLength: 10, // Set default number of rows to display
            lengthMenu: [10, 25, 50, 75, 100], // Options for number of rows to display
            stateSave: true, // Enable state saving
            stateSaveCallback: function(settings, data) {
                // Save state to localStorage
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data));
            },
            stateLoadCallback: function(settings) {
                // Load state from localStorage
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance));
            }
        });
        
        // This is to adjust for custom styling and make the DataTable fit well
        table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
  </script>

  <script>
    function editData(id) {
        // Make an AJAX call to get the data for the specific ID
        $.ajax({
            url: '/tambahData/' + id + '/edit', // Make sure this route is defined to return JSON data for the item
            type: 'GET',
            success: function(data) {
                // Populate the modal fields with the returned data
                $('#editModal #nama_anak').val(data.nama_anak);
                $('#editModal #tempat_lahir').val(data.tempat_lahir);
                $('#editModal #tanggal_lahir').val(data.tanggal_lahir);
                $('#editModal #jenis_kelamin').val(data.jenis_kelamin);
                $('#editModal #kecamatan').val(data.kecamatan);
                $('#editModal #detail_alamat').val(data.detail_alamat);
    
                // Set the form action for update
                $('#editModal form').attr('action', '/tambahData/' + id);
    
                // Open the modal
                $('#editModal').modal('show');
            }
        });
    }
    </script>

  <script>
    $(document).ready(function() {
    // Trigger for the delete button in the table row
    $('.delete-trigger').on('click', function() {
                    var id = $(this).data('id'); // Get the ID stored in the data-id attribute
                    var url = "{{ route('dataAnak.destroy', ':id') }}"; // The placeholder URL
                    url = url.replace(':id', id); // Replace the placeholder with the actual ID

                    // Set the form action
                    $('#deleteForm').attr('action', url);

                    // This sets the ID in the hidden input, if you are using it somewhere else. 
                    // If not, it is not necessary because you are passing the ID in the URL.
                    $('#deleteId').val(id);
                });

                // You could clear the form action when the modal is closed, as a safety measure
                $('#deleteModal').on('hidden.bs.modal', function () {
                    $('#deleteForm').attr('action', '');
                    $('#deleteId').val('');
                });
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
  document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mendapatkan tanggal dan waktu saat ini
    function getFormattedDateTime() {
      var now = new Date();
      return now.getFullYear() + "-" + (now.getMonth() + 1).toString().padStart(2, '0') + "-" + now.getDate().toString().padStart(2, '0') + "_" + now.getHours().toString().padStart(2, '0') + now.getMinutes().toString().padStart(2, '0') + now.getSeconds().toString().padStart(2, '0');
    }

    // Menghapus kolom 'Action' sebelum ekspor
    function removeActionColumn(data) {
      return data.map(row => {
        row.pop(); // Menghapus kolom terakhir (Action) dari setiap baris
        return row;
      });
    }

    // Fungsi untuk mengambil semua data dari DataTable
    function getAllData(table) {
      var data = [];
      table.rows().every(function(rowIdx) {
        data.push(this.data());
      });
      return data;
    }

    // Eksport ke CSV
    document.querySelector("#export-csv").addEventListener("click", function(event) {
      event.preventDefault();
      
      // Ambil semua data dari DataTable
      var table = $('#datatable-buttons').DataTable();
      var data = getAllData(table);
      var modifiedData = removeActionColumn(data);

      // Konversi data ke CSV menggunakan SheetJS
      var ws = XLSX.utils.aoa_to_sheet(modifiedData);
      var csv = XLSX.utils.sheet_to_csv(ws);

      // Buat dan unduh file CSV
      var csvBlob = new Blob([csv], {type: "text/csv;charset=utf-8;"});
      var link = document.createElement("a");
      var url = URL.createObjectURL(csvBlob);
      var dateTime = getFormattedDateTime();
      var filename = 'Data Status Gizi_' + dateTime + '.csv';

      link.href = url;
      link.download = filename;
      document.body.appendChild(link); // Tambahkan link ke dokumen untuk Firefox
      link.click();
      document.body.removeChild(link); // Bersihkan dengan menghapus link setelah klik
    });
  
    // Eksport ke Excel
    document.querySelector("#export-excel").addEventListener("click", function(event) {
      event.preventDefault();
      
      // Ambil semua data dari DataTable
      var table = $('#datatable-buttons').DataTable();
      var data = getAllData(table);
      var modifiedData = removeActionColumn(data);

      // Konversi data ke Excel menggunakan SheetJS
      var wb = XLSX.utils.book_new();
      var ws = XLSX.utils.aoa_to_sheet(modifiedData);
      XLSX.utils.book_append_sheet(wb, ws, "Data");
      XLSX.writeFile(wb, 'Data Status Gizi_' + getFormattedDateTime() + '.xlsx');
    });
  
    // Eksport ke PDF
    document.querySelector("#export-pdf").addEventListener("click", function(event) {
      event.preventDefault();
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // Ambil semua data dari DataTable
      var table = $('#datatable-buttons').DataTable();
      var data = getAllData(table);
      var modifiedData = removeActionColumn(data);

      // Format data untuk autoTable
      var headers = table.columns().header().map(header => $(header).text()).toArray();
      headers.pop(); // Menghapus header kolom 'Action'
      var rows = modifiedData;

      doc.autoTable({
        head: [headers],
        body: rows,
      });

      const filename = 'Data Status Gizi_' + getFormattedDateTime() + '.pdf';
      doc.save(filename);
    });
  });
</script>

  
@endsection




