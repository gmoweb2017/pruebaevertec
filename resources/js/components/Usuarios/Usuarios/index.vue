<template>
    <div class="container">
      <!-- Listado de usuarios -->
      <template v-if="formularios==0">
            <div class="col-md-12">
              <div class="panel-body" v-if="legacySystemHTML!=''">
                  <div class="form-group row text-center">
                      <div class="col-lg-12">
                          <div v-html="legacySystemHTML"></div>
                      </div>
                  </div>
              </div>
              <div class="card" v-if="legacySystemHTML==''">
                <div class="card-header">
                  <div class="card-head-row card-tools-still-right">
					          <h4 class="card-title">Listado de Usuarios </h4>
                    <div class="card-tools">
                      <button title="Busqueda" class="btn btn-icon btn-link btn-primary btn-xs" @click="abreFiltro()"><span class="fa fa-search"></span></button>
											<button title="Refrescar listado" @click="listarUsuarios(1,buscar,criterio,sortedColumn,order)" class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card" ><span class="fa fa-sync-alt"></span></button>
											<button v-if="acceso.crear==1" title="Nuevo Registro" @click="abrirModal('Usuario','registrar')" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-plus"></span></button>           
                    </div>
                  </div>  
                  <div class="card-head-row card-tools-still-right" v-if="oculta==1">
                    <div class="row">
                      <div class="col-md-3 col-lg-3">
                          <div class="form-group">
                              <select v-model="rol" class="form-control form-control">
                                  <option value="">Seleccione Rol</option>
                                  <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.rol_descripcion"></option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="name" placeholder="Ingrese el nombre">
                        </div>
                      </div>
                      <div class="col-md-3 col-lg-3">
                          <div class="form-group">                            
                              <input type="text" class="form-control" v-model="surname" placeholder="Ingrese apellido">
                          </div>
                      </div>
                      <div class="col-md-3 col-lg-3">
                            <div class="form-group">                              
                                <input type="text" class="form-control" v-model="username" placeholder="Ingrese el usuario">
                            </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button title="Busqueda" class="btn btn-icon btn-link btn-primary btn-xs" @click="listarUsuarios(1,buscar,criterio,sortedColumn,order)"><span class="fa fa-search"></span></button>											                        
                      </div>
                    </div>
                  </div>                 
				        </div>
                

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
  												<th scope="col">                            
                              <div class="card-head-row card-tools-still-right">                                    
                                <div class="card-tools">
                                  Usuario 
                                  <button v-if="order=='desc'" @click="orderColumn('username',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>                                  
                                  <button v-if="order=='asc'" @click="orderColumn('username',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-up"></span></button>
                                </div>
                              </div>
                          </th>
  												<th scope="col">
                            <div class="card-head-row card-tools-still-right">                                    
                                <div class="card-tools">
                                  Nombre 
                                  <button v-if="order=='desc'" @click="orderColumn('name',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>                                  
                                  <button v-if="order=='asc'" @click="orderColumn('name',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-up"></span></button>
                                </div>
                              </div>
                          </th>
  												<th scope="col">
                            <div class="card-head-row card-tools-still-right">                                    
                                <div class="card-tools">
                                  Apellido 
                                  <button v-if="order=='desc'" @click="orderColumn('surname',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>                                  
                                  <button v-if="order=='asc'" @click="orderColumn('surname',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-up"></span></button>
                                </div>
                              </div>
                          </th>
  												<th scope="col">
                            <div class="card-head-row card-tools-still-right">                                    
                                <div class="card-tools">
                                  Correo 
                                  <button v-if="order=='desc'" @click="orderColumn('email',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>                                  
                                  <button v-if="order=='asc'" @click="orderColumn('email',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-up"></span></button>
                                </div>
                              </div>
                          </th>
                          <!--<th scope="col">
                            <div class="card-head-row card-tools-still-right">                                    
                                <div class="card-tools">
                                  Rol 
                                  <button v-if="order=='desc'" @click="orderColumn('rol_descripion',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>                                  
                                  <button v-if="order=='asc'" @click="orderColumn('rol_descripion',order)" class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-up"></span></button>
                                </div>
                              </div>
                          </th>-->
                          <th scope="col">Estado</th>
                          <th scope="col">Acciones</th>
  											</tr>
                      </thead>
                      <tbody>
                        <tr v-for="Usuario in arrayUsuario" :key="Usuario.id">
                          <td v-text="Usuario.username"></td>
                          <td v-text="Usuario.name"></td>
                          <td v-text="Usuario.surname"></td>
                          <td v-text="Usuario.email"></td>
                          <!--<td v-text="Usuario.rolname"></td>-->
                          <td>
                              <div v-if="Usuario.activo">
                                  <span class="badge badge-success">Activo</span>
                              </div>
                              <div v-else>
                                  <span class="badge badge-danger">Desactivado</span>
                              </div>
                          </td>
                          <td>
                              <span v-if="acceso.editar==1">
                              <button type="button" data-toggle="tooltip" data-placement="top" title="Editar Registro" @click="abrirModal('Usuario','actualizar',Usuario)" class="btn btn-sm btn-icon btn-round btn-info">
                              <i class="icon-pencil"></i>
                              </button>
                              </span>
                              <span v-if="acceso.eliminar==1">
                                <template v-if="Usuario.activo">
                                    <button type="button" class="btn btn-sm btn-icon btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Desactivar Registro" @click="desactivar(Usuario.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-sm btn-icon btn-round btn-danger" data-toggle="tooltip" data-placement="top" title="Activar Registro" @click="activar(Usuario.id)">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                              </span>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                    <nav class="pull-right">
                      <ul class="pagination">
                          <li class="page-item" v-if="pagination.current_page > 1">
                              <a class="page-link  btn-pty-primary" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio,sortedColumn,order)">Ant</a>
                          </li>
                          <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                              <a class="page-link btn-pty-primary" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,sortedColumn,order)" v-text="page"></a>
                          </li>
                          <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                              <a class="page-link btn-pty-primary" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio,sortedColumn,order)">Sig</a>
                          </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
      </template>
      <!-- Formulario de Creacion y Edición de usuarios -->
      <template v-if="formularios==1">
        <div class="col-md-12">
          <div class="panel-body" v-if="legacySystemHTML!=''">
              <div class="form-group row text-center">
                  <div class="col-lg-12">
                      <div v-html="legacySystemHTML"></div>
                  </div>
              </div>
          </div>
          <div class="card" v-if="legacySystemHTML==''">
            <div class="card-header">
              <h4 class="card-title"><span v-text="tituloModal"></span></h4>
            </div>
            <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row">
                  <div class="col-md-6 col-lg-4">
                        <div class="form-group">
    												<label for="name">Rol</label>
                            <select v-model="rol" class="form-control form-control">
                                <option value="">Seleccione Rol</option>
                                <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.rol_descripcion"></option>
                            </select>
    										</div>
                   </div>

                </div>
                <div class="row">
                  <div class="col-md-6 col-lg-4">
                    <div class="form-group">
												<label for="name">Nombre</label>
												<input type="text" class="form-control" v-model="name" placeholder="Ingrese el nombre">
										</div>
                   </div>
                 <div class="col-md-6 col-lg-4">
                       <div class="form-group">
   												<label for="name">Apellidos</label>
   												<input type="text" class="form-control" v-model="surname" placeholder="Ingrese los apellidos">
   										</div>
                  </div>
                  <div class="col-md-6 col-lg-4">
                        <div class="form-group">
    												<label for="name">Usuario</label>
    												<input type="text" class="form-control" v-model="username" placeholder="Ingrese el usuario">
    										</div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-md-6 col-lg-4">
                     <div class="form-group">
 												<label for="name">Email</label>
 												<input type="email" class="form-control" v-model="email" placeholder="Ingrese el correo electronico">
 										</div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                         <div class="form-group">
     												<label for="name">Contraseña</label>
     												<input type="password" class="form-control" v-model="password" placeholder="Ingrese la contraseña">
     										</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
  												<label for="name">Activo</label>
                          <select v-model="activo" class="form-control form-control">
                              <option value="">Seleccione Estado Usuario</option>
                              <option value="0">Inactivo</option>
                              <option value="1">Activo</option>
                          </select>
  										</div>
                     </div>
                  </div>
                  <!--<div v-show="errorUsuario" class="form-group row div-error">
                        <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">
                            </div>
                        </div>
                  </div>-->

                <div class="row pull-right">
                      <div class="text-right form-animate-text">
                          <input class="submit btn btn-success" v-if="tipoAccion==1" @click="registrar()" type="button" value="Guardar">
                          <input class="submit btn btn-info" v-if="tipoAccion==2" @click="actualizar()" type="button" value="Actualizar">
                          <input class="submit btn btn-danger" type="button" @click="cerrarFormulario()" value="Cancelar">
                      </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </template>
    </div>
</template>
<script src="./src/script.component.js"></script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

    
</style>
