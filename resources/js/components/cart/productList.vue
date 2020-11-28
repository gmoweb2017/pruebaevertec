<template>
  <div class="card">
    <div class="page-inner">
      <div class="page-header">
        <h4 class="page-title">Proceso de compra</h4>
        
      </div>
    </div>
    <div class="row m-2" v-if="customerEditOpen == 'table'">
 
      <div class="col-lg-4 col-md-6 col-xs-12"  v-for="Product in arrayProduct" :key="Product.id">
          
        <div class="card card-info card-annoucement card-round">
          <div class="card-body text-center">
            <div class="card-opening">{{Product.nombreProducto}}</div>
            <div class="card-desc">
              ${{Product.precio}}
            </div>
            <div class="card-detail">
              <a class="btn btn-light btn-rounded" @click="comprar(Product)">Comprar</a>
            </div>
          </div>
        </div>
      
    </div>
    </div>

    <customerEdit
      :Producto = "Producto"
      :Precio = "precio"
      @closeModal="closeModal"
      v-else-if="customerEditOpen == 'createEdit'"
    ></customerEdit>
  </div>
</template>
<script src="./src/script.product.js"></script>

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
