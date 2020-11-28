import customerEdit from "../customerEdit";

export default {
  components: {
    customerEdit
  },
  data() {
    return {
      legacySystemHTML: '',
      formularios: 0,
      arrayProduct: [],
      pagination: {
        'total': 0,
        'current_page': 0,
        'per_page': 0,
        'last_page': 0,
        'from': 0,
        'to': 0,
      },
      customerEditOpen: 'table',
      offset: 3,
      sortedColumn: 'nombreProducto',
      order: 'asc',
      criterio: 'nombreProducto',
      buscar: '',
      Producto: '',
      precio: 0,
    }
  },

  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },

  },
  methods: {
    cambiarPagina(page, buscar, criterio, sortedColumn, order) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarProducts(page, buscar, criterio, sortedColumn, order);
    },
    listarProducts(page, buscar, criterio, sortedColumn, order) {
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';

      var filtro1 = me.filtro1;
      var filtro2 = me.filtro2;
      var filtro3 = me.filtro3;
      var filtro4 = me.filtro4;

      var url = '/ProductFront/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&column=' + sortedColumn + '&order=' + order + '&filtro1=' + filtro1 + '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4=' + filtro4;
      axios.get(url).then(function(response) {
          var respuesta = response.data;
          me.arrayProduct = respuesta.listado.data;
          me.pagination = respuesta.pagination;
          me.legacySystemHTML = ''
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    comprar(Product) {

      this.Producto = Product.nombreProducto;
      this.precio = Product.precio;
      this.customerEditOpen = "createEdit";
    },
    closeModal() {

    },
  },
  mounted() {
    this.listarProducts(1, this.buscar, this.criterio, this.sortedColumn, this.order);
  }
}