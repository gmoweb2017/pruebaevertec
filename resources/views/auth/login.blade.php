@extends('layouts.app')
@section('tituloPagina', 'Inicio Sesión | '.$nameApp )

@section('contenido')

<div id="app">
	<div class="">
			<div class="content">
				<div class="page-inner">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-5 login">
							<div class="card-pricing2 card-info">
								<div class="pricing-header">
									<h3 class="fw-bold text-center"><font color="black">{{$nameApp}}</font></h3>
								</div>
								<div class="price-value">
									<div class="">
										<span class=""><img src="{{$logo}}" alt="navbar brand" width="300px" class=""></span>
									
									</div>
								</div>
								<form class="m-t-md" method="POST"  action="{{ route('login')}}">
                				{{ csrf_field() }}
								<div class="row mt-5 justify-content-center">
									<div class="col-lg-6">
										<div class="form-group">
												<div class="input-icon">
													<span class="input-icon-addon">
														<i class="fa fa-user"></i>
													</span>
													<input type="text" class="form-control" value="{{old('usuario')}}" name="usuario" id="usuario"  placeholder="Usuario">


												</div>
												<span>{!!$errors->first('usuario','<span class="bg-info">:message</span>')!!}</span>
										</div>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-6">
										<div class="form-group">
												<div class="input-icon">
													<span class="input-icon-addon">
														<i class="fas fa-hashtag"></i>
													</span>
													<input type="password" class="form-control" name="password" id="password"  placeholder="Contraseña">

												</div>
												<span>{!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}</span>
										</div>
									</div>
								</div>

								<button class="btn btn-info btn-border btn-lg w-65 fw-bold mb-3">Ingresar</button>
								<br /><a href="#" class="btn-border">Olvido la contraseña?</a>
								<br /><br />
								<span class="copyright ml-auto"><font color="#000">Copyright @<?php echo date('Y'); ?><br /> Desarrollado para {{$copy}} por <a href="{{$webdeveloper}}" target="_blank">{{$developer}} </a></font></span>
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
