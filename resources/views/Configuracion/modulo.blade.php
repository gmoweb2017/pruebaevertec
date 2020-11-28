@extends('layouts.cabecera')
@section('tituloPagina', 'Configuración App')

@section('contenido')

@if($consultar->consultar==1)
<div id="app">
  <div class="main-panel">
    <div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Modulos </h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="/">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Configuración</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Modulos</a>
							</li>
						</ul>
					</div>
        </div>
        <div class="row">
          <!-- Llamando componente Usuarios.vue-->

          <modulo :acceso="{{$consultar}}" :nombre="'{{$nameApp}}'"  :direccion="'{{$address}}'"  :telefono="'{{$phone}}'"  :developer="'{{$developer}}'"  :webdeveloper="'{{$webdeveloper}}'"  :web="'{{$web}}'"  :pais="'{{$country}}'"  :email="'{{$email}}'"  :copy="'{{$copy}}'" :logo="'{{$logo}}'"></modulo>
        </div>
      </div>
  </div>

</div>
@else
  <script>window.location = "/tablero";</script>
@endif
@stop
