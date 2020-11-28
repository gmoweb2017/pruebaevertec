@extends('layouts.app')
@section('tituloPagina', 'ERROR DE ACCESO')

@section('contenido')

<div id="app">
	<div class="">
			<div class="content">
				<div class="page-inner">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
							<div class="card-pricing2 card-info">
								<div class="pricing-header">
									<h1 class="fw-bold text-center">No tienes acceso a esta sección<br><small>Contacte con el administrador</small></h1>
									
								</div>
								<div class="price-value">
									<div class="value">
										<span class="currency"><img src="../img/psychology.png" alt="navbar brand" width="60%" class=""></span>
										<span class="month"></span>
									</div>
								</div>
								<form class="m-t-md" method="POST"  action="{{ route('login')}}">
                				{{ csrf_field() }}
								<div class="row mt-5 justify-content-center">
									<div class="col-lg-6">
										<div class="form-group">
												<div class="input-icon">
												
										</div>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-6">
										<div class="form-group">
												<div class="input-icon">
													
										</div>
									</div>
								</div>

								
								
								<span class="copyright ml-auto"><font color="#000">Copyright @<?php echo date('Y'); ?><br /> Desarrollado por Demage</font></span>
								</form>
							</div>
						</div>
          </div>
        </div>
      </div>
			<input type="hidden" name="ruta" id="ruta" value="inicio" />
</div>
</div>
@stop
