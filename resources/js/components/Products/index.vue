<template>
  <div class="container">
    <!-- Listado de Products -->
    <template v-if="formularios == 0">
      <div class="col-md-12">
        <div class="panel-body" v-if="legacySystemHTML != ''">
          <div class="form-group row text-center">
            <div class="col-lg-12">
              <div v-html="legacySystemHTML"></div>
            </div>
          </div>
        </div>
        <div class="card" v-if="legacySystemHTML == ''">
          <div class="card-header">
            <div class="card-head-row card-tools-still-right">
              <h4 class="card-title">Listado de Products</h4>
              <div class="card-tools">
                <button
                  title="Busqueda"
                  class="btn btn-icon btn-link btn-primary btn-xs"
                  @click="abreFiltro()"
                >
                  <span class="fa fa-search"></span>
                </button>
                <button
                  title="Refrescar listado"
                  @click="
                    listarProducts(1, buscar, criterio, sortedColumn, order)
                  "
                  class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"
                >
                  <span class="fa fa-sync-alt"></span>
                </button>
                <button
                  v-if="acceso.crear == 1"
                  title="Nuevo Registro"
                  @click="abrirModal('Product', 'registrar')"
                  class="btn btn-icon btn-link btn-primary btn-xs"
                >
                  <span class="fa fa-plus"></span>
                </button>
              </div>
            </div>
            <div
              class="card-head-row card-tools-still-right"
              v-if="oculta == 1"
            >
              <div class="row">
                <div class="col-md-3 col-lg-4">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="filtro1"
                      placeholder="Ingrese el nombre"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-lg-4">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="filtro2"
                      placeholder="Ingrese dirección"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-lg-4">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="filtro3"
                      placeholder="Ingrese email"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <button
                    title="Busqueda"
                    class="btn btn-icon btn-link btn-primary btn-xs"
                    @click="
                      listarProducts(1, buscar, criterio, sortedColumn, order)
                    "
                  >
                    <span class="fa fa-search"></span>
                  </button>
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
                          Nombre
                          <button
                            v-if="order == 'desc'"
                            @click="orderColumn('nombreProducto', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-down"></span>
                          </button>
                          <button
                            v-if="order == 'asc'"
                            @click="orderColumn('nombreProducto', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-up"></span>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th scope="col">
                      <div class="card-head-row card-tools-still-right">
                        <div class="card-tools">
                          Precio
                          <button
                            v-if="order == 'desc'"
                            @click="orderColumn('precio', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-down"></span>
                          </button>
                          <button
                            v-if="order == 'asc'"
                            @click="orderColumn('precio', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-up"></span>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th scope="col">
                      <div class="card-head-row card-tools-still-right">
                        <div class="card-tools">
                          Estado
                          <button
                            v-if="order == 'desc'"
                            @click="orderColumn('activo', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-down"></span>
                          </button>
                          <button
                            v-if="order == 'asc'"
                            @click="orderColumn('activo', order)"
                            class="btn btn-icon btn-link btn-primary btn-xs"
                          >
                            <span class="fa fa-angle-up"></span>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th scope="col">Fecha de creación</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="Product in arrayProduct" :key="Product.id">
                    <td v-text="Product.nombreProducto"></td>
                    <td v-text="Product.precio"></td>
                    <td>
                      <div v-if="Product.activo">
                        <span class="badge badge-success">Activo</span>
                      </div>
                      <div v-else>
                        <span class="badge badge-danger">Desactivado</span>
                      </div>
                    </td>
                    <td v-text="Product.created_at"></td>
                    <td>
                      <span v-if="acceso.editar == 1">
                        <button
                          type="button"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Editar Registro"
                          @click="
                            abrirModal('Product', 'actualizar', Product)
                          "
                          class="btn btn-sm btn-icon btn-round btn-info"
                        >
                          <i class="icon-pencil"></i>
                        </button>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <nav class="pull-right">
                <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                    <a
                      class="page-link btn-pty-primary"
                      href="#"
                      @click.prevent="
                        cambiarPagina(
                          pagination.current_page - 1,
                          buscar,
                          criterio,
                          sortedColumn,
                          order
                        )
                      "
                      >Ant</a
                    >
                  </li>
                  <li
                    class="page-item"
                    v-for="page in pagesNumber"
                    :key="page"
                    :class="[page == isActived ? 'active' : '']"
                  >
                    <a
                      class="page-link btn-pty-primary"
                      href="#"
                      @click.prevent="
                        cambiarPagina(
                          page,
                          buscar,
                          criterio,
                          sortedColumn,
                          order
                        )
                      "
                      v-text="page"
                    ></a>
                  </li>
                  <li
                    class="page-item"
                    v-if="pagination.current_page < pagination.last_page"
                  >
                    <a
                      class="page-link btn-pty-primary"
                      href="#"
                      @click.prevent="
                        cambiarPagina(
                          pagination.current_page + 1,
                          buscar,
                          criterio,
                          sortedColumn,
                          order
                        )
                      "
                      >Sig</a
                    >
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </template>
    <!-- Formulario de Creacion y Edición de Products -->
    <template v-if="formularios == 1">
      <div class="col-md-12">
        <div class="panel-body" v-if="legacySystemHTML != ''">
          <div class="form-group row text-center">
            <div class="col-lg-12">
              <div v-html="legacySystemHTML"></div>
            </div>
          </div>
        </div>
        <div class="card" v-if="legacySystemHTML == ''">
          <div class="card-header">
            <h4 class="card-title"><span v-text="tituloModal"></span></h4>
          </div>
          <div class="card-body">
            <form
              action=""
              method="post"
              enctype="multipart/form-data"
              class="form-horizontal"
            >
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="nombreProducto"
                      placeholder="Nombre"
                    />
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="name">Precio</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="precio"
                      placeholder="Precio"
                    />
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="name">Activo</label>
                    <select v-model="activo" class="form-control form-control">
                      <option value="">Seleccione Estado</option>
                      <option value="0">Inactivo</option>
                      <option value="1">Activo</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row pull-right">
                <div class="text-right form-animate-text">
                  <input
                    class="submit btn btn-success"
                    v-if="tipoAccion == 1"
                    @click="registrar()"
                    type="button"
                    value="Guardar"
                  />
                  <input
                    class="submit btn btn-info"
                    v-if="tipoAccion == 2"
                    @click="actualizar()"
                    type="button"
                    value="Actualizar"
                  />
                  <input
                    class="submit btn btn-danger"
                    type="button"
                    @click="cerrarFormulario()"
                    value="Cancelar"
                  />
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
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
