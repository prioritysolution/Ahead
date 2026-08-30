<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from smarthr.co.in/demo/html/template/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Aug 2025 17:18:23 GMT -->
<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{$title ?? env('APP_NAME')}}</title>
	
	<meta name="description" content="SmartHR - An advanced Bootstrap 5 admin dashboard template for HRM and CRM. Ideal for managing employee records, payroll, attendance, recruitment, and team performance with an intuitive and responsive design. Perfect for HR teams and business managers looking to streamline workforce management.">
	<meta name="keywords" content="HR dashboard template, HRM admin template, Bootstrap 5 HR dashboard, workforce management dashboard, employee management system, payroll dashboard, HR analytics, admin dashboard, CRM admin template, human resources management, HR admin template, team management dashboard, recruitment dashboard, employee attendance system, performance management, HR CRM, HR dashboard HTML, Bootstrap HR template, employee engagement, HR software, project management dashboard">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/img/apple-touch-icon.png')}}">

	<!-- Favicon -->
	<link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon">
	<link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon">

	<!-- Theme Script js -->
	<script src="{{asset('assets/js/theme-script.js')}}"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/icons/feather/feather.css')}}">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">

	<!-- Bootstrap Tagsinput CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-lite.min.css')}}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="{{asset('assets/plugins/flatpickr/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/%40simonwep/pickr/themes/nano.min.css')}}">

    @stack('style')

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

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

<body>
<div id="nb-global-spinner" class="spinner">
    <div class="blob blob-0">
        
    </div>
  </div>