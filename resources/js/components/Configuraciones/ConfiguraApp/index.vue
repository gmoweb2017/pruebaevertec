<template>
    <div class="container">
      <!-- Listado de Roless -->
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
									<h4 class="card-title">Configuración App
                  </h4>
								</div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                    <div class="row">
                      <div class="col-md-8 col-lg-8">
                        <div class="row">
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" v-model="nombreApp" placeholder="Ingrese el nombre">
                                </div>
                          </div>
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Dirección</label>
                                    <input type="text" class="form-control" v-model="direccionA" placeholder="Ingrese el nombre">
                                </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Teléfono</label>
                                    <input type="text" class="form-control" v-model="telefonoA" placeholder="Ingrese el nombre">
                                </div>
                          </div>
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Web</label>
                                    <input type="text" class="form-control" v-model="webA" placeholder="Ingrese el nombre">
                                </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Pais</label>
                                    <input type="text" class="form-control" v-model="paisA" placeholder="Ingrese el nombre">
                                </div>
                          </div>                      
                          <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" class="form-control" v-model="emailA" placeholder="Ingrese el nombre">
                                </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-lg-12">
                                <div class="row pull-right">
                                    <div class="text-right form-animate-text">
                                        <input class="submit btn btn-success" v-if="tipoAccion==1" @click="registrar()" type="button" value="Guardar">
                                        <input class="submit btn btn-info" v-if="tipoAccion==2" @click="actualizar()" type="button" value="Actualizar">
                                        <input class="submit btn btn-danger" type="button" @click="cerrarFormulario()" value="Cancelar">
                                    </div>
                              </div>
                          </div>                      
                        </div>
                      </div>
                      <div class="col-md-4 col-lg-4">
                        <div class="row">
                          <div class="col-md-4 col-lg-12">
                            <div class="form-group">
                                    <label for="name">Logo</label>
                                    <input class="form-control" style="margin-bottom: 20px;" type="file" accept="image/jpeg" @change="subirImagen" name="imagen" id="" capture="camera">
                                    
                            </div>
                          </div>
                          <div class="col-md-4 col-lg-12 text-center">
                            <div class="form-group">
                                   <img v-if="valorForm==''" src="http://via.placeholder.com/350x150" class="img-fluid" style="width:100%" alt="imagen"> 
                                   <img v-else :src="valorForm" class="img-fluid" style="width:200px" alt="imagen">
                            </div>
                          </div>
                        </div>
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
