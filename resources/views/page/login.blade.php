<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Stunting</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('asset/vendors/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('asset/vendors/font-awesome/css/font-awesome.min.css')}}">
    <!-- NProgress -->
    <link rel="stylesheet" href="{{ asset('asset/vendors/nprogress/nprogress.css')}}">
    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('asset/vendors/animate.css/animate.min.css')}}">
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.min.css') }}">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
              @csrf <!-- CSRF token for security -->
              <h1>Login Form</h1>
              <div>
                <input type="email" class="form-control" name="email" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                {{-- <p class="change_link">
                  Belum punya akun ?
                  <a href="#signup" class="to_register"> Buat Akun </a>
                </p> --}}
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-check-circle"></i> Stunting</h1>
                </div>
              </div>
            </form>
          </section>
        </div>

        {{-- <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <h1>Buat Akun</h1>
              <div>
                <input type="text" class="form-control" name="name" placeholder="Name" required="" />
              </div>
              <div>
                <input type="email" class="form-control" name="email" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Register</button>
              </div>
            </form>
            <div class="clearfix"></div>
        
            <div class="separator">
              <p class="change_link">
                Sudah punya akun ?
                <a href="#signin" class="to_register"> Login </a>
              </p>
        
              <div class="clearfix"></div>
              <br />
              <div>
                <h1><i class="fa fa-check-circle"></i> Stunting</h1>
              </div>
            </div>
          </section>
        </div>         --}}
      </div>
    </div>

    <script>
      window.onbeforeunload = function() {
        // Call to a Laravel route that will handle the logout
        navigator.sendBeacon('/logout');
    };
    </script>
    
  </body>
</html>

