@extends('layout/navbar')

@section('title', 'Tambah Data')

@section('konten')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
      <div class="page-title">
          <div class="title_left">
              <h3>Tambah Data</h3>
          </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                      <h2>Tambah Data </h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                      <form class="form-horizontal form-label-left" action="{{ route('tambahData.store') }}" method="POST">
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
                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_anak">Nama <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="nama_anak" class="form-control col-md-7 col-xs-12" name="nama_anak" placeholder="Nama Lengkap" required="required" type="text" value="{{ old('nama_anak') }}">
                                  @error('nama_anak')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="nik" class="form-control col-md-7 col-xs-12" name="nik" placeholder="NIK" required="required" type="text" value="{{ old('nik') }}">
                                  @error('nik')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="tempat_lahir" class="form-control col-md-7 col-xs-12" name="tempat_lahir" placeholder="Tempat Lahir" required="required" type="text" value="{{ old('tempat_lahir') }}">
                                  @error('tempat_lahir')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="date" id="tanggal_lahir" name="tanggal_lahir" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('tanggal_lahir') }}">
                                  @error('tanggal_lahir')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required="required">
                                      <option value="" disabled selected class="placeholder">Pilih Jenis Kelamin</option>
                                      <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                      <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                  </select>
                                  @error('jenis_kelamin')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kecamatan">Kecamatan <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="form-control" id="kecamatan" name="kecamatan" required="required">
                                      <option value="" disabled selected class="placeholder">Pilih Kecamatan</option>
                                      <option value="Bayat" {{ old('kecamatan') == 'Bayat' ? 'selected' : '' }}>Bayat</option>
                                      <option value="Cawas" {{ old('kecamatan') == 'Cawas' ? 'selected' : '' }}>Cawas</option>
                                      <option value="Ceper" {{ old('kecamatan') == 'Ceper' ? 'selected' : '' }}>Ceper</option>
                                      <option value="Delanggu" {{ old('kecamatan') == 'Delanggu' ? 'selected' : '' }}>Delanggu</option>
                                      <option value="Gantiwarno" {{ old('kecamatan') == 'Gantiwarno' ? 'selected' : '' }}>Gantiwarno</option>
                                      <option value="Jatinom" {{ old('kecamatan') == 'Jatinom' ? 'selected' : '' }}>Jatinom</option>
                                      <option value="Jogonalan" {{ old('kecamatan') == 'Jogonalan' ? 'selected' : '' }}>Jogonalan</option>
                                      <option value="Kalikotes" {{ old('kecamatan') == 'Kalikotes' ? 'selected' : '' }}>Kalikotes</option>
                                      <option value="Karanganom" {{ old('kecamatan') == 'Karanganom' ? 'selected' : '' }}>Karanganom</option>
                                      <option value="Karangdowo" {{ old('kecamatan') == 'Karangdowo' ? 'selected' : '' }}>Karangdowo</option>
                                      <option value="Kemalang" {{ old('kecamatan') == 'Kemalang' ? 'selected' : '' }}>Kemalang</option>
                                      <option value="Klaten Selatan" {{ old('kecamatan') == 'Klaten Selatan' ? 'selected' : '' }}>Klaten Selatan</option>
                                      <option value="Klaten Tengah" {{ old('kecamatan') == 'Klaten Tengah' ? 'selected' : '' }}>Klaten Tengah</option>
                                      <option value="Klaten Utara" {{ old('kecamatan') == 'Klaten Utara' ? 'selected' : '' }}>Klaten Utara</option>
                                      <option value="Manisrenggo" {{ old('kecamatan') == 'Manisrenggo' ? 'selected' : '' }}>Manisrenggo</option>
                                      <option value="Ngawen" {{ old('kecamatan') == 'Ngawen' ? 'selected' : '' }}>Ngawen</option>
                                      <option value="Pedan" {{ old('kecamatan') == 'Pedan' ? 'selected' : '' }}>Pedan</option>
                                      <option value="Polanharjo" {{ old('kecamatan') == 'Polanharjo' ? 'selected' : '' }}>Polanharjo</option>
                                      <option value="Prambanan" {{ old('kecamatan') == 'Prambanan' ? 'selected' : '' }}>Prambanan</option>
                                      <option value="Trucuk" {{ old('kecamatan') == 'Trucuk' ? 'selected' : '' }}>Trucuk</option>
                                      <option value="Tulung" {{ old('kecamatan') == 'Tulung' ? 'selected' : '' }}>Tulung</option>
                                      <option value="Wedi" {{ old('kecamatan') == 'Wedi' ? 'selected' : '' }}>Wedi</option>
                                      <option value="Wonosari" {{ old('kecamatan') == 'Wonosari' ? 'selected' : '' }}>Wonosari</option>
                                  </select>
                                  @error('kecamatan')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detail_alamat">Detail Alamat <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <textarea id="detail_alamat" required="required" name="detail_alamat" placeholder="Alamat Lengkap" class="form-control col-md-7 col-xs-12">{{ old('detail_alamat') }}</textarea>
                                  @error('detail_alamat')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="ln_solid"></div>
                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-3">
                                  <button type="button" class="btn btn-primary" onclick="window.location.href='/tambahData'">Batal</button>
                                  <button id="send" type="submit" class="btn btn-success">Submit</button>
                              </div>
                          </div>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- /page content -->

<!-- footer content -->
      <footer>
        <div class="pull-right">
          <!-- Stunting -->
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>

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
  </div>
@endsection

