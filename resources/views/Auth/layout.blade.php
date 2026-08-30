<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from smarthr.co.in/demo/html/template/login by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Aug 2025 17:22:57 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title ?? env('APP_NAME')}}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    @stack('style')


    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
<style>
    @-webkit-keyframes spin {
      0% {
        transform: rotate(0)
      }

      100% {
        transform: rotate(360deg)
      }
    }

    @-moz-keyframes spin {
      0% {
        -moz-transform: rotate(0)
      }

      100% {
        -moz-transform: rotate(360deg)
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0)
      }

      100% {
        transform: rotate(360deg)
      }
    }

    .spinner {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1003;
      background: #ffff;
      overflow: hidden
    }

    .spinner div:first-child {
      display: block;
      position: relative;
      left: 45.5%;
      top: 47%;
      width: 200px;
      height: 200px;
      margin: -75px 0 0 -75px;
      border-radius: 50%;
      background-image: url("{{ asset('assets/img/logo1.svg') }}");
      background-size: 150px;
      background-repeat: no-repeat;
      background-position: center;
      box-shadow: 0 11px 19px 0 #2d7e91;
      transform: translate3d(0, 0, 0);
      animation: spin 4s linear infinite;
    }
</style>
<body class="bg-white">

    {{-- <div id="global-loader">
        <div class="page-loader"></div>
    </div> --}}
    <div id="nb-global-spinner" class="spinner">
    <div class="blob blob-0">
        
    </div>
  </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">
                    <div class="col-lg-5">
                        <div
                            class="login-background position-relative d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100">
                            <div class="bg-overlay-img">
                                <img src="{{ asset('/assets/img/bg/bg-01.png') }}" class="bg-1" alt="Img">
                                <img src="{{ asset('/assets/img/bg/bg-02.png') }}" class="bg-2" alt="Img">
                                <img src="{{ asset('/assets/img/bg/bg-03.png') }}" class="bg-3" alt="Img">
                            </div>
                            <div class="authentication-card w-100">
                                <div class="authen-overlay-item border w-100">
                                    <h1 class="text-white display-1">Empowering people <br> through seamless HR <br>
                                        management.</h1>
                                    <div class="my-4 mx-auto authen-overlay-img">
                                        <img src="{{ asset('/assets/img/bg/authentication-bg-01.png') }}"
                                            alt="Img" width="150" height="80">
                                    </div>
                                    <div>
                                        <p class="text-white fs-20 fw-semibold text-center">Efficiently manage your
                                            workforce, streamline <br> operations effortlessly.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                            <div class="col-md-7 mx-auto vh-100">
                                <form>
                                    <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
                                        <div class=" mx-auto mb-5 text-center">
                                            <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid"
                                                alt="Logo" width="150" height="200">
                                        </div>
                                        @yield('contain')
                                        <div class="mt-5 pb-4 text-center">
                                            <p class="mb-0 text-gray-9">Copyright &copy; 2025 - WorkSphere</p>
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
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    @stack('script')

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    


</body>


<!-- Mirrored from smarthr.co.in/demo/html/template/login by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Aug 2025 17:22:57 GMT -->

</html>
