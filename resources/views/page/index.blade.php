@extends('layout/navbar')

@section('title', 'Dashboard')

@section('konten')
<!-- page content -->
<div class="right_col" role="main">
  <div class="row ">
    <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="tile-stats">
        <div class="count text-center">Sistem Pencegahan Stunting</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="d-flex justify-co">
          <div class="row justify-content-center align-items-center">
            <div class="col-lg-4">
              <img src="asset/img/4574122.jpg" style="width: 100%; height: 100%; object-fit: cover;" />
            </div>             
            <div class="my-auto">
              <h1>Welcome, {{ Auth::user()->name }}</h1>
              <p style="font-size: 14px">
                Sistem Pencegahan Stunting adalah solusi inovatif yang dirancang untuk mengetahui status stunting dan gizi pada anak usia 0 hingga 24 bulan, 
                yang hanya dapat diakses oleh petugas kesehatan. Ini memungkinkan deteksi dini dan intervensi yang tepat,
                memastikan tumbuh kembang anak optimal dalam fase kritis mereka.
              </p>
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
      <!-- <div class="pull-right">
           Stunting
      </div> -->
    <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->



@endsection
