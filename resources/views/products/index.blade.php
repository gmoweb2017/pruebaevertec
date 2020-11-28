@extends('layouts.cabecera')
@section('tituloPagina', 'Administración de Productos')

@section('contenido')

@if($consultar->consultar==1)
<div id="app">
  <div class="main-panel">
    <div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Productos</h4>
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
								<a href="#">Listado</a>
							</li>
							
						</ul>
					</div>
        </div>
        <div class="row">
          <products :acceso="{{$consultar}}"></products>
        </div>
      </div>
  </div>

</div>
@else
  <script>window.location = "/tablero";</script>
@endif
@stop
