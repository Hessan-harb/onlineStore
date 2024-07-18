<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Admin Dashboard">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="shiping, products, orders , stores , ">
	<title>Admin Dashboard </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('backend/assets/vendors/core/core.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/fonts/feather-font/css/iconfont.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/css/demo2/style.css')}}">
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.png')}}" />
    @stack('styles')

</head>
<body>
	<div class="main-wrapper">
    <!-- partial:partials/_sidebar.html -->
    {{-- @include('dashboard\sidbebar') --}}
	<x-nav /> 
	
	    <div class="page-wrapper">
			<!-- partial:partials/_navbar.html -->
			@include('dashboard\nav')
			<!-- partial -->
	@yield('content')

	<!-- core:js -->
	<script src="{{asset('backend/assets/vendors/core/core.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
	<script src="{{asset('backend/assets/vendors/feather-icons/feather.min.js')}}"></script>
	<script src="{{asset('backend/assets/js/template.js')}}"></script>
    <script src="{{asset('backend/assets/js/dashboard-dark.js')}}"></script>
    @stack('script')
</body>
</html>    