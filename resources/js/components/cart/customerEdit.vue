<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Datos del cliente</h4>
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
                    v-model="customer_name"
                    placeholder="Nombre"
                  />
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="name">Dirección</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="customer_address"
                    placeholder="Dirección"
                  />
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="name">Teléfono</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="customer_mobile"
                    placeholder="Teléfono"
                  />
                </div>
              </div>

              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="name">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    v-model="customer_email"
                    placeholder="Email"
                  />
                </div>
              </div>
            </div>
           
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
        <div class="card">
        <div class="card-header">
          <h4 class="card-title">Datos de compra</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Producto: </h4>
                <ul>
                    <li>{{Producto}} x 1

                    </li>
                </ul>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <h4>Total: </h4>
                        </div>
                        <div class="col-lg-7 text-right">
                            ${{Precio}}
                        </div>
                    </div>
                
                </div>
            </div>
             <div class="row pull-right">
              <div class="text-right form-animate-text">
                  <img src="/img/logop.png" width="150px">
                <input
                  class="submit btn btn-success"
                  v-if="tipoAccion == 1"
                  @click="registrar()"
                  type="button"
                  value="Pagar"
                />
              </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</template>
<script src="./src/script.customer.js"></script>

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
