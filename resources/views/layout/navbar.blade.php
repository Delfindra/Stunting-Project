<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{asset('asset/img/icon.png')}}">
  <title>@yield('title')</title>

  <!-- Bootstrap -->
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('asset/vendors/bootstrap/dist/css/bootstrap.min.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/font-awesome/css/font-awesome.min.css')}}">

  <!-- NProgress -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/nprogress/nprogress.css')}}">

  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/iCheck/skins/flat/green.css')}}">

  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/jqvmap/dist/jqvmap.min.css')}}">

  <!-- bootstrap-daterangepicker -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">

  <!-- Datatables -->
  <link rel="stylesheet" href="{{ asset('asset/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}">

  <!-- Custom Theme Style -->
  <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/css/custom.min.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/echarts@5.0.0/dist/echarts.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
</head>

<body>
    <body class="nav-md">
        <div class="container body">
          <div class="main_container">
            <div class="col-md-3 left_col">
              <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                  <a href="/" class="site_title"><i class="fa-solid fa-heart-pulse"></i> <span>Stunting</span></a>
                  {{-- <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Stunting</span></a> --}}
                </div>
                <div class="clearfix"></div>
      
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                  <div class="profile_pic">
                    <img src="{{asset('asset/img/user_1077114.png')}}" alt="..." class="img-circle profile_img">
                  </div>
                  <div class="profile_info">
                    <span>Welcome,</span>
                    @auth
                    <h2>{{ Auth::user()->name }}</h2> <!-- Only display the name if the user is authenticated -->
                    @else
                      <h2>Guest</h2> <!-- Display "Guest" or some other text if the user is not authenticated -->
                    @endauth
                  </div>
                </div>
                <!-- /menu profile quick info -->
                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                  <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                      <li><a href="/"><i class="fa fa-home"></i> Dashboard</span></a></li>
                      <li><a href="/sebaranStatusGizi"><i class="fa fa-map-marker"></i> Sebaran Status Gizi</a></li>
                      <li><a href="/lihatData"><i class="fa fa-table"></i> Status Gizi</a></li>
                    </ul>
                  </div>
                </div>
                <!-- /sidebar menu -->
              </div>
            </div>
      
            <!-- top navigation -->
            <div class="top_nav">
              <div class="nav_menu">
                <nav>
                  <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                  </div>
                  <ul class="nav navbar-nav navbar-right">
                    @auth
                    <li class="">
                      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('asset/img/user_1077114.png') }}" alt="">{{ Auth::user()->name }}
                        <span class=" fa fa-angle-down"></span>
                      </a>
                      <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <i class="fa fa-sign-out pull-right"></i> Log Out
                          </a>
                        </li>
                      </ul>
                    </li>
                    @endauth
                    @guest
                    <li>
                      <a href="{{ route('login') }}">Login</a>
                    </li>
                  @endguest
                  </ul>                  
                </nav>
              </div>
            </div>
            <!-- /top navigation -->
    
            <div>
                @yield('konten')
            </div>

              <!-- footer content -->
              <footer>
                <!-- <div class="pull-right">
                  Stunting
                </div> -->
              <div class="clearfix"></div>
              </footer>
              <!-- /footer content -->
          </div>
        </div>

  
    <!-- jQuery -->
    <script src="{{ asset('asset/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- morris.js -->
    <script src="{{ asset('asset/vendors/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/morris.js/morris.min.js') }}"></script>

    <!-- ECharts -->
    <script src="{{ asset('asset/vendors/echarts/dist/echarts.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/echarts/map/js/world.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('asset/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('asset/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/pdfmake/build/vfs_fonts.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('asset/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('asset/vendors/fastclick/lib/fastclick.js') }}"></script>

    <!-- NProgress -->
    <script src="{{ asset('asset/vendors/nprogress/nprogress.js') }}"></script>

    <!-- Chart.js -->
    <script src="{{ asset('asset/vendors/Chart.js/dist/Chart.min.js') }}"></script>

    <!-- gauge.js -->
    <script src="{{ asset('asset/vendors/gauge.js/dist/gauge.min.js') }}"></script>

    <!-- bootstrap-progressbar -->
    <script src="{{ asset('asset/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    
    <!-- iCheck -->
    <script src="{{ asset('asset/vendors/iCheck/icheck.min.js') }}"></script>

    <!-- Skycons -->
    <script src="{{ asset('asset/vendors/skycons/skycons.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('asset/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('asset/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('asset/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('asset/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('asset/vendors/Flot/jquery.flot.resize.js') }}"></script>

    <!-- Flot plugins -->
    <script src="{{ asset('asset/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('asset/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/flot.curvedlines/curvedLines.js') }}"></script>

    {{-- DateJS  --}}
    <script src="{{ asset('asset/vendors/DateJS/build/date.js') }}"></script>

    {{-- JQVMap --}}
    <script src="{{ asset('asset/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('asset/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('asset/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>

    {{-- bootstrap-daterangepicker --}}
    <script src="{{ asset('asset/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('asset/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    {{-- font Awesome --}}
    <script src="https://kit.fontawesome.com/96184bddb0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom Theme Scripts --}}
    <script src="{{ asset('asset/js/custom.js') }}"></script>
    <script src="{{ asset('asset/js/custom.min.js') }}"></script>
    
</body>
</html>
