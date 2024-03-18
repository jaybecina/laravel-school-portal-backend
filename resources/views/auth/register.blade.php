<!--
=========================================================
* Material Dashboard 2 - v3.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>
    Material Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css" rel="stylesheet') }}" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js') }}" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('{{ asset('assets/img/illustrations/illustration-signup.jpg') }}'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  <h4 class="font-weight-bolder">Teacher Registration</h4>
                  <p class="mb-0">Fill up the fields</p>
                </div>
                <div class="card-body">
                  {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                  {{-- <form action="{{ route('users.store') }}" method="POST" role="form" > --}}
                    @csrf
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('First Name') }}</label>
                      <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="off" autofocus>
                      @error('first_name')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Middle Name') }}</label>
                      <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" required autocomplete="off" autofocus>
                      @error('middle_name')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Last Name') }}</label>
                      <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" autofocus>
                      @error('last_name')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Contact Number') }}</label>
                      <input type="text" class="form-control @error('contact_num') is-invalid @enderror" name="contact_num" value="{{ old('contact_num') }}" required autocomplete="off" autofocus>
                      @error('contact_num')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Email Address') }}</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                      @error('email')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Password') }}</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="off" autofocus>
                      @error('password')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">{{ __('Confirm Password') }}</label>
                      <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="off" autofocus>
                      @error('password_confirmation')
                        <span class="invalid-feedback" role="alert" align=right>
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    {{-- <div class="input-group input-group-outline mb-3">
                      <label class="form-label"></label>
                      <select class="form-control">
                        <option value="" selected>Select a Role</option>
                        <option value="teacher" selected>Teacher</option>
                        <option value="student" selected>Student</option>
                      </select>
                    </div> --}}
                    {{-- <div class="form-check form-check-info text-start ps-0">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div> --}}
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">{{ __('Register') }}</button>
                    </div>
                  {{-- </form> --}}
                  {!! Form::close() !!}
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">{{ __('Login') }}</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js') }}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>