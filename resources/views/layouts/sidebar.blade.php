@if(Auth::check())
<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="../img/user4.jpg" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{ ucfirst(Auth::user()->name).' '.Auth::user()->surname }}
									<span class="user-level">{{ ucfirst(Auth::user()->username) }}</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">Mi perfil</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Configuración</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item <?php if(\Request::route()->getName()=='tablero'){ echo 'active'; }?>">
							<a data-toggle="" href="/" class="" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Inicio</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menú</h4>
						</li>					
						
						<li class="nav-item">
							<a data-toggle="collapse" href="#orders">
								<i class="fas fa-list"></i>
								<p>Ordenes</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="orders">
								<ul class="nav nav-collapse">
									<li>
										<a href="#">
											<span class="sub-item">Listar</span>
										</a>
									</li>
								</ul>
							</div>
						</li>


						
						@if(Auth::user()->hasRole(['Super Admin']) || Auth::user()->hasRole(['Administrador']))						
						<li class="nav-item">
							<a data-toggle="collapse" href="#clientes">
								<i class="fas fa-users"></i>
								<p>Clientes</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="clientes">
								<ul class="nav nav-collapse">
									<li>
										<a href="#">
											<span class="sub-item">Listar</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<li class="nav-item <?php if(\Request::route()->getName()=='Usuario.usuarios' || \Request::route()->getName()=='Usuario.roles' || \Request::route()->getName()=='Configuracion.configura' || \Request::route()->getName()=='Configuracion.modulo'){ echo 'active'; }?>">
							<a data-toggle="collapse" href="#submenu">
								<i class="fas fa-cogs"></i>
								<p>Configuraciones</p>
								<span class="caret"></span>
							</a>
							
							<div class="collapse" id="submenu">
								<ul class="nav nav-collapse">	
									@if(Auth::user()->hasRole(['Super Admin']))								
									<li>
										<a href="{{route('Configuracion.configura')}}">
											<span class="sub-item">Configuración App</span>
										</a>
									</li>
									<li>
										<a href="{{route('Configuracion.modulo')}}">
											<span class="sub-item">Modulos</span>
										</a>
									</li>	
									@endif
									<li>
										<a href="{{route('Usuario.usuarios')}}">
											<span class="sub-item">Usuarios</span>
										</a>
									</li>
									<li>
										<a href="{{route('Usuario.roles')}}">
											<span class="sub-item">Roles</span>
										</a>
									</li>
								</ul>
							</div>
							
						</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->
@endif
