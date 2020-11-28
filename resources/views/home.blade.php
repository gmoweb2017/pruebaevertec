@extends('layouts.cabecera')
@section('tituloPagina', 'Tablero Principal ')

@section('contenido')
<div id="app">


<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner">
						<div class="mt-2 mb-4">
							<h2 class="text-white pb-2">Bienvenido, {{ ucfirst(Auth::user()->name).' '.Auth::user()->surname }}!</h2>
							<h5 class="text-white op-7 mb-4"></h5>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row">
						<div class="col-md-4">
							<div class="card card-dark bg-primary-gradient">
								<div class="card-body pb-0">
									<div class="h1 fw-bold float-right">+5%</div>
									<h2 class="mb-2">17</h2>
									<p>Ofertas</p>
									<div class="pull-in sparkline-fix chart-as-background">
										<div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-dark bg-secondary-gradient">
								<div class="card-body pb-0">
									<div class="h1 fw-bold float-right">-3%</div>
									<h2 class="mb-2">27</h2>
									<p>Pedidos</p>
									<div class="pull-in sparkline-fix chart-as-background">
										<div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-dark bg-success2">
								<div class="card-body pb-0">
									<div class="h1 fw-bold float-right">+7%</div>
									<h2 class="mb-2">213</h2>
									<p>Clientes</p>
									<div class="pull-in sparkline-fix chart-as-background">
										<div id="lineChart3"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<footer class="footer">
				<div class="container-fluid">

					<div class="copyright ml-auto">
						Copyright @<?php echo date('Y'); ?>, Desarrollado para {{$copy}} por <a href="{{$webdeveloper}}" target="_blank">{{$developer}} </a>
					</div>
				</div>
			</footer>
		</div>
</div>

@endsection
