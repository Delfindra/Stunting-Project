@extends('layout/navbar')

@section('title', 'Sebaran Status Gizi')

@section('konten')
<!-- page content -->
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa-solid fa-baby"></i></div>
          <div class="count">{{$totalStunting}}</div>
          <h3>Total Stunting</h3>
          {{-- <p>Lorem ipsum psdea itgum rixt.</p> --}}
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa-solid fa-baby"></i></div>
          <div class="count">{{$totalGiziBuruk}}</div>
          <h3>Total Gizi Buruk</h3>
          {{-- <p>Lorem ipsum psdea itgum rixt.</p> --}}
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa-solid fa-baby"></i></div>
          <div class="count">{{$totalUnderweight}}</div>
          <h3>Total Underweight</h3>
          {{-- <p>Lorem ipsum psdea itgum rixt.</p> --}}
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa-solid fa-baby"></i></div>
          <div class="count">{{$totalAnak}}</div>
          <h3>Total Data</h3>
          {{-- <p>Lorem ipsum psdea itgum rixt.</p> --}}
        </div>
      </div>
    </div>
    <!-- /top tiles -->

    {{-- status gizi --}}
    <div class="row">
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Persebaran Status Gizi</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <button id="export_btn_csv_persebaran" class="btn-sm btn-primary">Export to CSV</button>
                <button id="export_btn_excel_persebaran" class="btn-sm btn-primary">Export to Excel</button>
                  <div class="form-group">
                      <label for="filter_bulan_gizi">Pilih Bulan:</label>
                      <select id="filter_bulan_gizi" class="form-control">
                          <option value="">Semua Bulan</option>
                          @foreach ($monthsYears as $monthYear)
                              <option value="{{ $monthYear->year }}-{{ str_pad($monthYear->month, 2, '0', STR_PAD_LEFT) }}">
                                  {{ date('F Y', mktime(0, 0, 0, $monthYear->month, 1)) }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="canvas-container">
                      <canvas id="mainb"></canvas>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 col-sm-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Perbandingan Intervensi Perwilayah</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button id="export_btn_csv_intervensi" class="btn-sm btn-primary">Export to CSV</button>
                <button id="export_btn_excel_intervensi" class="btn-sm btn-primary">Export to Excel</button>
                <div class="form-group">
                    <label for="filter_bulan_intervensi">Pilih Bulan:</label>
                    <select id="filter_bulan_intervensi" class="form-control">
                        <option value="">Semua Bulan</option>
                        @foreach ($monthsYears as $monthYear)
                            <option value="{{ $monthYear->year }}-{{ str_pad($monthYear->month, 2, '0', STR_PAD_LEFT) }}">
                                {{ date('F Y', mktime(0, 0, 0, $monthYear->month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="canvas-container">
                    <canvas id="intervensiChart"></canvas>
                </div>
            </div>
         </div>
      </div>
      
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Peta Persebaran Status Gizi</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="dashboard-widget-content">
                      <div id="mapid" class="col-md-12 col-sm-12" style="height:700px;"></div>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="col-md-6 col-sm-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Perbandingan Faktor Determinan Perwilayah</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button id="export_btn_csv_faktor" class="btn-sm btn-primary">Export to CSV</button>
                <button id="export_btn_excel_faktor" class="btn-sm btn-primary">Export to Excel</button>
                <div class="form-group">
                    <label for="filter_bulan_faktor">Pilih Bulan:</label>
                    <select id="filter_bulan_faktor" class="form-control">
                        <option value="">Semua Bulan</option>
                        @foreach ($monthsYears as $monthYear)
                            <option value="{{ $monthYear->year }}-{{ str_pad($monthYear->month, 2, '0', STR_PAD_LEFT) }}">
                                {{ date('F Y', mktime(0, 0, 0, $monthYear->month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="canvas-container">
                    <canvas id="faktorDeterminanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tren Persebaran Status Gizi di Kabupaten Klaten</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button id="export_btn_csv_tren" class="btn-sm btn-primary">Export to CSV</button>
                <button id="export_btn_excel_tren" class="btn-sm btn-primary">Export to Excel</button>
                <div class="form-group">
                    <label for="filter_bulan_tren">Pilih Bulan:</label>
                    <select id="filter_bulan_tren" class="form-control">
                        <option value="">Semua Bulan</option>
                        @foreach ($monthsYears as $monthYear)
                            <option value="{{ $monthYear->year }}-{{ str_pad($monthYear->month, 2, '0', STR_PAD_LEFT) }}">
                                {{ date('F Y', mktime(0, 0, 0, $monthYear->month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="canvas-container">
                    <canvas id="line_chart"></canvas>
                </div>
            </div>
        </div>
    </div>
 
    </div>
    <br/>

  </div>
  <!-- /page content -->
</div>

<script type="text/javascript">
  // Pastikan kecamatanStats tersedia dengan benar
  var kecamatanStats = @json($kecamatanStats);
  var faktorDeterminan = @json($faktorDeterminan);
  console.log("Loaded Faktor Determinan:", faktorDeterminan);
  console.log("Loaded Kecamatan Stats:", kecamatanStats);

  var mymap = L.map('mapid').setView([-7.6804, 110.6646], 11);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© Dinas Kesehatan Kabupaten Klaten'
  }).addTo(mymap);

  // Fungsi untuk menggabungkan statistik ke dalam GeoJSON
  function mergeStatsIntoGeoJSON(geoJSONData, stats) {
    geoJSONData.features.forEach(function(feature) {
      var kecamatanStat = stats.find(stat => stat.kecamatan === feature.properties.WADMKC);
      if (kecamatanStat) {
        feature.properties.stunting = kecamatanStat.stunting;
        feature.properties.giziBuruk = kecamatanStat.gizi_buruk;
        feature.properties.underweight = kecamatanStat.underweight;
      } else {
        console.log('No stats found for kecamatan:', feature.properties.WADMKC);
      }
    });
    return geoJSONData;
  }

  // Mengambil GeoJSON dan menggabungkan data statistik
  fetch('{{ asset("asset/GeoJSON/KLT.geojson") }}')
    .then(response => response.json())
    .then(data => {
        var mergedGeoJSON = mergeStatsIntoGeoJSON(data, kecamatanStats);
        console.log("Merged GeoJSON Data:", mergedGeoJSON);
        L.geoJson(mergedGeoJSON, {
            style: getStyle,
            onEachFeature: onFeatureClick
        }).addTo(mymap);
    })
    .catch(err => console.error('Error loading GeoJSON data:', err));

  // Fungsi untuk menentukan style peta
  function getStyle(feature) {
    let maxPercentage = Math.max(feature.properties.stunting, feature.properties.giziBuruk, feature.properties.underweight);
    return { fillColor: getColor(maxPercentage), color: 'white', weight: 1, opacity: 1, fillOpacity: 0.9 };
  }

  function getColor(value) {
    return value > 3 ? 'red' : value > 2 ? '#FFA500' : 'green';
  }

  // Fungsi untuk menangani klik pada fitur dan menambahkan label
  function onFeatureClick(feature, layer) {
    layer.on('click', function(e) {
        var kecamatan = feature.properties.WADMKC;
        var dataDeterminan = faktorDeterminan.find(fd => fd.kecamatan === kecamatan);

        var popupContent = `<b>Kecamatan:</b> ${kecamatan}<br>` +
                           `<b>Stunting:</b> ${feature.properties.stunting || 'Data Tidak Tersedia'}<br>` +
                           `<b>Gizi Buruk:</b> ${feature.properties.giziBuruk || 'Data Tidak Tersedia'}<br>` +
                           `<b>Underweight:</b> ${feature.properties.underweight || 'Data Tidak Tersedia'}<br>` +
                           `<b>Tidak Tersedia Akses Air Bersih:</b> ${dataDeterminan ? dataDeterminan.airBersih : 'Data Tidak Tersedia'}<br>` +
                           `<b>Tidak Tersedia Akses Jamban Sehat:</b> ${dataDeterminan ? dataDeterminan.jambanSehat : 'Data Tidak Tersedia'}<br>` +
                           `<b>Imunisasi:</b> ${dataDeterminan ? dataDeterminan.imunisasi : 'Data Tidak Tersedia'}<br>` +
                           `<b>Kecacingan:</b> ${dataDeterminan ? dataDeterminan.kecacingan : 'Data Tidak Tersedia'}<br>` +
                           `<b>Merokok:</b> ${dataDeterminan ? dataDeterminan.merokok : 'Data Tidak Tersedia'}<br>` +
                           `<b>KEK:</b> ${dataDeterminan ? dataDeterminan.riwayatKehamilan : 'Data Tidak Tersedia'}`;
        layer.bindPopup(popupContent).openPopup();
    });
    createLabel(feature, layer);
}

  // Fungsi untuk membuat label dengan nama wilayah
  function createLabel(feature, layer) {
    if (feature.properties && feature.properties.WADMKC) {
      var label = L.marker(layer.getBounds().getCenter(), {
        icon: L.divIcon({
          className: 'custom-label', 
          html: feature.properties.WADMKC,
          iconSize: [100, 40]
        })
      }).addTo(mymap);
    }
  }
</script>

{{-- grafik --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const defaultMonthYear = ''; 
        let mainbChart;

        function fetchMainbData(monthYear = defaultMonthYear) {
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    updateMainbChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function updateMainbChart(data) {
            const ctx = document.getElementById('mainb').getContext('2d');
            if (mainbChart) {
                mainbChart.destroy();
            }
            mainbChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.kecamatanLabels,
                    datasets: [
                        {
                            label: 'Stunting',
                            backgroundColor: 'rgb(255, 99, 132)',
                            data: data.stuntingData,
                        },
                        {
                            label: 'Gizi Buruk',
                            backgroundColor: 'rgb(54, 162, 235)',
                            data: data.giziBurukData,
                        },
                        {
                            label: 'Underweight',
                            backgroundColor: 'rgb(255, 206, 86)',
                            data: data.underweightData,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function (value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }

        function exportMainbToCSV(data, monthYear) {
            const csvRows = [];
            const headers = ['Kecamatan', 'Stunting', 'Gizi Buruk', 'Underweight'];
            csvRows.push(headers.join(','));

            for (let i = 0; i < data.kecamatanLabels.length; i++) {
                const row = [
                    data.kecamatanLabels[i],
                    data.stuntingData[i] || 0,
                    data.giziBurukData[i] || 0,
                    data.underweightData[i] || 0
                ];
                csvRows.push(row.join(','));
            }

            const csvString = csvRows.join('\n');
            const blob = new Blob([csvString], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', `persebaran_status_gizi_${monthYear}.csv`);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function exportMainbToExcel(data, monthYear) {
            const ws_data = [];
            const headers = ['Kecamatan', 'Stunting', 'Gizi Buruk', 'Underweight'];
            ws_data.push(headers);

            for (let i = 0; i < data.kecamatanLabels.length; i++) {
                const row = [
                    data.kecamatanLabels[i],
                    data.stuntingData[i] || 0,
                    data.giziBurukData[i] || 0,
                    data.underweightData[i] || 0
                ];
                ws_data.push(row);
            }

            const ws = XLSX.utils.aoa_to_sheet(ws_data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Mainb');

            XLSX.writeFile(wb, `persebaran_status_gizi_${monthYear}.xlsx`);
        }

        // Fetch default data when page loads
        fetchMainbData();

        // Add event listener for month selection
        document.getElementById('filter_bulan_gizi').addEventListener('change', function (e) {
            const monthYear = e.target.value;
            fetchMainbData(monthYear);
        });

        // Add event listener for export buttons
        document.getElementById('export_btn_csv_persebaran').addEventListener('click', function () {
            const monthYear = document.getElementById('filter_bulan_gizi').value || defaultMonthYear;
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    exportMainbToCSV(data, monthYear);
                })
                .catch(error => console.error('Error fetching data:', error));
        });

        document.getElementById('export_btn_excel_persebaran').addEventListener('click', function () {
            const monthYear = document.getElementById('filter_bulan_gizi').value || defaultMonthYear;
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    exportMainbToExcel(data, monthYear);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
</script>
    
{{-- intervensi --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const defaultMonthYear = ''; 
        let intervensiChart;
    
        function fetchIntervensiData(monthYear = defaultMonthYear) {
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    updateIntervensiChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    
        function updateIntervensiChart(data) {
            const ctx = document.getElementById('intervensiChart').getContext('2d');
            if (intervensiChart) {
                intervensiChart.destroy();
            }
            intervensiChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.intervensiLabels,
                    datasets: [
                        {
                            label: 'Rujuk ke Rumah Sakit',
                            backgroundColor: 'rgb(255, 99, 132)',
                            data: data.intervensiRujukKeRumahSakit,
                        },
                        {
                            label: 'Pemberian PMT',
                            backgroundColor: 'rgb(54, 162, 235)',
                            data: data.intervensiPemberianPMT,
                        },
                        {
                            label: 'Pemberian Edukasi',
                            backgroundColor: 'rgb(255, 206, 86)',
                            data: data.intervensiPemberianEdukasi,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function (value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    
        function exportIntervensiToCSV(data, monthYear) {
            const csvRows = [];
            const headers = ['Kecamatan', 'Rujuk ke Rumah Sakit', 'Pemberian PMT', 'Pemberian Edukasi'];
            csvRows.push(headers.join(','));
    
            for (let i = 0; i < data.intervensiLabels.length; i++) {
                const row = [
                    data.intervensiLabels[i],
                    data.intervensiRujukKeRumahSakit[i] || 0,
                    data.intervensiPemberianPMT[i] || 0,
                    data.intervensiPemberianEdukasi[i] || 0
                ];
                csvRows.push(row.join(','));
            }
    
            const csvString = csvRows.join('\n');
            const blob = new Blob([csvString], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', `persebaran_status_gizi_intervensi_${monthYear}.csv`);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    
        function exportIntervensiToExcel(data, monthYear) {
            const ws_data = [];
            const headers = ['Kecamatan', 'Rujuk ke Rumah Sakit', 'Pemberian PMT', 'Pemberian Edukasi'];
            ws_data.push(headers);
    
            for (let i = 0; i < data.intervensiLabels.length; i++) {
                const row = [
                    data.intervensiLabels[i],
                    data.intervensiRujukKeRumahSakit[i] || 0,
                    data.intervensiPemberianPMT[i] || 0,
                    data.intervensiPemberianEdukasi[i] || 0
                ];
                ws_data.push(row);
            }
    
            const ws = XLSX.utils.aoa_to_sheet(ws_data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Intervensi');
    
            XLSX.writeFile(wb, `persebaran_status_gizi_intervensi_${monthYear}.xlsx`);
        }
    
        // Fetch default data when page loads
        fetchIntervensiData();
    
        // Add event listener for month selection
        document.getElementById('filter_bulan_intervensi').addEventListener('change', function (e) {
            const monthYear = e.target.value;
            fetchIntervensiData(monthYear);
        });
    
        // Add event listener for export buttons
        document.getElementById('export_btn_csv_intervensi').addEventListener('click', function () {
            const monthYear = document.getElementById('filter_bulan_intervensi').value || defaultMonthYear;
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    exportIntervensiToCSV(data, monthYear);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    
        document.getElementById('export_btn_excel_intervensi').addEventListener('click', function () {
            const monthYear = document.getElementById('filter_bulan_intervensi').value || defaultMonthYear;
            fetch(`/api/sebaran-data?monthYear=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    exportIntervensiToExcel(data, monthYear);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
    </script>
    
{{-- faktor determinan --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultMonthYear = ''; 
    let faktorDeterminanChart;

    function fetchFaktorDeterminanData(monthYear = defaultMonthYear) {
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                updateFaktorDeterminanChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateFaktorDeterminanChart(data) {
        const ctx = document.getElementById('faktorDeterminanChart').getContext('2d');
        if (faktorDeterminanChart) {
            faktorDeterminanChart.destroy();
        }
        faktorDeterminanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.kecamatanLabels,
                datasets: [
                    {
                        label: 'Tidak Tersedia Akses Air Bersih',
                        backgroundColor: 'rgb(255, 99, 132)',
                        data: data.airBersihData,
                    },
                    {
                        label: 'Tidak Tersedia Akses Jamban Sehat',
                        backgroundColor: 'rgb(54, 162, 235)',
                        data: data.jambanSehatData,
                    },
                    {
                        label: 'Imunisasi',
                        backgroundColor: 'rgb(255, 206, 86)',
                        data: data.imunisasiData,
                    },
                    {
                        label: 'Kecacingan',
                        backgroundColor: 'rgb(75, 192, 192)',
                        data: data.kecacinganData,
                    },
                    {
                        label: 'Merokok',
                        backgroundColor: 'rgb(153, 102, 255)',
                        data: data.merokokData,
                    },
                    {
                        label: 'KEK',
                        backgroundColor: 'rgb(255, 159, 64)',
                        data: data.riwayatKehamilanData,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    }

    function exportFaktorToCSV(data, monthYear) {
        const csvRows = [];
        const headers = ['Kecamatan', 'Akses Air Bersih', 'Akses Jamban Sehat', 'Imunisasi', 'Kecacingan', 'Merokok', 'KEK'];
        csvRows.push(headers.join(','));

        for (let i = 0; i < data.kecamatanLabels.length; i++) {
            const row = [
                data.kecamatanLabels[i],
                data.airBersihData[i] || 0,
                data.jambanSehatData[i] || 0,
                data.imunisasiData[i] || 0,
                data.kecacinganData[i] || 0,
                data.merokokData[i] || 0,
                data.riwayatKehamilanData[i] || 0
            ];
            csvRows.push(row.join(','));
        }

        const csvString = csvRows.join('\n');
        const blob = new Blob([csvString], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('hidden', '');
        a.setAttribute('href', url);
        a.setAttribute('download', `persebaran_status_gizi_${monthYear}.csv`);
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function exportFaktorToExcel(data, monthYear) {
        const ws_data = [];
        const headers = ['Kecamatan', 'Akses Air Bersih', 'Akses Jamban Sehat', 'Imunisasi', 'Kecacingan', 'Merokok', 'KEK'];
        ws_data.push(headers);

        for (let i = 0; i < data.kecamatanLabels.length; i++) {
            const row = [
                data.kecamatanLabels[i],
                data.airBersihData[i] || 0,
                data.jambanSehatData[i] || 0,
                data.imunisasiData[i] || 0,
                data.kecacinganData[i] || 0,
                data.merokokData[i] || 0,
                data.riwayatKehamilanData[i] || 0
            ];
            ws_data.push(row);
        }

        const ws = XLSX.utils.aoa_to_sheet(ws_data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Faktor Determinan');

        XLSX.writeFile(wb, `persebaran_status_gizi_${monthYear}.xlsx`);
    }

    // Fetch default data when page loads
    fetchFaktorDeterminanData();

    // Add event listener for month selection
    document.getElementById('filter_bulan_faktor').addEventListener('change', function (e) {
        const monthYear = e.target.value;
        fetchFaktorDeterminanData(monthYear);
    });

    // Add event listener for export buttons
    document.getElementById('export_btn_csv_faktor').addEventListener('click', function () {
        const monthYear = document.getElementById('filter_bulan_faktor').value || defaultMonthYear;
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                exportFaktorToCSV(data, monthYear);
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    document.getElementById('export_btn_excel_faktor').addEventListener('click', function () {
        const monthYear = document.getElementById('filter_bulan_faktor').value || defaultMonthYear;
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                exportFaktorToExcel(data, monthYear);
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});
</script>    

{{-- tren persebaran status gizi --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultMonthYear = ''; 
    let lineChart;

    const monthLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    function fetchLineData(monthYear = defaultMonthYear) {
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                updateLineChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateLineChart(data) {
        const ctx = document.getElementById('line_chart').getContext('2d');
        if (lineChart) {
            lineChart.destroy();
        }
        lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: data.trenStatusGiziDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Anak'
                        }
                    }
                }
            }
        });
    }

    function exportToCSV(data, monthYear) {
        const csvRows = [];
        const headers = ['Bulan', ...data.trenStatusGiziDatasets.map(dataset => dataset.label)];
        csvRows.push(headers.join(','));

        monthLabels.forEach((month, index) => {
            const row = [month];
            data.trenStatusGiziDatasets.forEach(dataset => {
                row.push(dataset.data[index] || 0);
            });
            csvRows.push(row.join(','));
        });

        const csvString = csvRows.join('\n');
        const blob = new Blob([csvString], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('hidden', '');
        a.setAttribute('href', url);
        a.setAttribute('download', `persebaran_status_gizi_${monthYear}.csv`);
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function exportToExcel(data, monthYear) {
        const ws_data = [];
        const headers = ['Bulan', ...data.trenStatusGiziDatasets.map(dataset => dataset.label)];
        ws_data.push(headers);

        monthLabels.forEach((month, index) => {
            const row = [month];
            data.trenStatusGiziDatasets.forEach(dataset => {
                row.push(dataset.data[index] || 0);
            });
            ws_data.push(row);
        });

        const ws = XLSX.utils.aoa_to_sheet(ws_data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Tren Status Gizi');

        XLSX.writeFile(wb, `persebaran_status_gizi_${monthYear}.xlsx`);
    }

    // Fetch default data when page loads
    fetchLineData();

    // Add event listener for month selection
    document.getElementById('filter_bulan_tren').addEventListener('change', function (e) {
        const monthYear = e.target.value;
        fetchLineData(monthYear);
    });

    // Add event listener for export buttons
    document.getElementById('export_btn_csv_tren').addEventListener('click', function () {
        const monthYear = document.getElementById('filter_bulan_tren').value || defaultMonthYear;
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                exportToCSV(data, monthYear);
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    document.getElementById('export_btn_excel_tren').addEventListener('click', function () {
        const monthYear = document.getElementById('filter_bulan_tren').value || defaultMonthYear;
        fetch(`/api/sebaran-data?monthYear=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                exportToExcel(data, monthYear);
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});
</script>

@endsection
