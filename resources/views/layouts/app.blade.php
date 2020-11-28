<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('tituloPagina')</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <meta name="description" content="Desarrollado por Genaro Muñoz Obregón">
  <meta name="author" content="Genaro Muñoz Obregón">
  <meta name="keyword" content="">
	<link rel="icon" href="../img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('js/backend_js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../css/backend_css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('css/backend_css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('css/backend_css/crm.css')}}">
</head>
<body>
    <div class="wrapper">
      @yield('contenido')

  	@extends('layouts.pie')
