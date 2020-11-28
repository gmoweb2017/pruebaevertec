<template>
    <div class="container">
      <!-- Listado de Bases -->
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
									<h4 class="card-title">Listado de Bases
                    <span v-if="acceso.crear==1">
                      <button type="button" class="btn btn-success pull-right" @click="abrirModal('Base','registrar')">
  											<i class="fa fa-plus"> Nuevo</i>
  										</button>
                    </span>
                  </h4>
								</div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-head-bg-info">
                      <thead>
                        <tr>
  												<th scope="col">Código Base</th>
  												<th scope="col">Código Proveedor</th>
  												<th scope="col">Nombre Base</th>
                          <th scope="col">Precio COP</th>
                          <th scope="col">Activo</th>
                          <th scope="col">Acciones</th>
  											</tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                    <nav class="pull-right">
                      <ul class="pagination">
                          <li class="page-item" v-if="pagination.current_page > 1">
                              <a class="page-link  btn-pty-primary" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                          </li>
                          <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                              <a class="page-link btn-pty-primary" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                          </li>
                          <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                              <a class="page-link btn-pty-primary" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                          </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
      </template>
      <!-- Formulario de Creacion y Edición -->
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

                </div>
                <div v-show="error" class="form-group row div-error">
                      <div class="text-center text-error">
                          <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                          </div>
                      </div>
                </div>
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

<script>
    export default {
        props:['acceso'],
        data(){
          return{
            legacySystemHTML:'',
            formularios:0,
            array: [],
            pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                    },
            offset : 3,
            criterio : 'nombre',
            buscar : '',
            tipoAccion : 0,
            tituloModal: '',
            error: 0,
            errorMostrarMsj: [],
          }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
          cambiarPagina(page,buscar,criterio,filtrado){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar,criterio,filtrado);
            },
          abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "Base":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.formularios = 1;
                                this.tipoAccion = 1;
                                this.tituloModal = 'Registrar';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.formularios=1;
                                this.tipoAccion=2;
                                this.tituloModal='Actualizar';
                                this.id_Base=data['id'];
                                break;
                            }
                            case 'visualizar':
                            {
                                this.formularios=3;
                                this.tipoAccion=1;
                                this.tituloModal='Ficha Base';
                                break;
                            }
                        }
                    }
                }
          },
            cerrarFormulario(){
                  this.formularios=0;
                  this.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
                  this.tituloModal='';
                  this.legacySystemHTML='';
                  this.error=0;
            },
            listar(page,buscar,criterio){

            },
            registrar(){

            },
            actualizar(){

            },
            validar(){

            },
            desactivar(id){

            },
            activar(id){

            },
        },
        mounted() {

          //this.listarBases(1,this.buscar,this.criterio);
        }
    }
</script>
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
