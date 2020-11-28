export default {
  props: ['acceso'],
  data() {
    return {
      legacySystemHTML: '',
      formularios: 0,
      arrayOrder: [],
      arrayRol: [],
      pagination: {
        'total': 0,
        'current_page': 0,
        'per_page': 0,
        'last_page': 0,
        'from': 0,
        'to': 0,
      },
      offset: 3,
      sortedColumn: 'created_at',
      order: 'asc',
      criterio: 'created_at',
      buscar: '',
      tipoAccion: 0,
      tituloModal: '',
      Order_id: 0,
      newOrder: 'asc',
      errorProduct: 0,
      errorMostrarMsjProduct: [],
      oculta: 0,
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
      me.listarOrders(page, buscar, criterio, sortedColumn, order);
    },
    abreFiltro() { //Despliega los filtros en el listado
      console.log(this.oculta);
      if (this.oculta == 0) {
        this.oculta = 1;
      } else {
        this.oculta = 0;
      }
    },
    orderColumn(sortedColumn, order) { //Recibe el ordercolumn para saber si es Asc o Desc
      if (order == 'asc') {
        this.order = 'desc'
        order = 'desc'
      } else {
        this.order = 'asc'
        order = 'asc'
      }
      this.listarOrders(1, this.buscar, this.criterio, sortedColumn, order);
    },
    abrirModal(modelo, accion, data = []) { //Controla la apertura de formulario o listado
      this.formularios = 1;
      switch (modelo) {
        case "Product":
          {
            switch (accion) {
              case 'actualizar':
                {
                  this.formularios = 1;
                  this.tipoAccion = 2;
                  this.tituloModal = 'Actualizar Product';
                  this.Order_id = data['id'];
                  this.nombreProducto = data['nombreProducto'];
                  this.precio = data['precio'];
                  this.activo = data['activo'];
                  break;
                }
            }
          }
      }
    },
    cerrarFormulario() {
      this.formularios = 0;
      this.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
      this.tituloModal = '';
      this.Order_id = 0;
      this.nombreProducto = '';
      this.precio = '';
      this.activo = '';
      this.legacySystemHTML = '';
      this.errorProduct = 0;
    },
    listarOrders(page, buscar, criterio, sortedColumn, order) {
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';

      var filtro1 = me.filtro1;
      var filtro2 = me.filtro2;
      var filtro3 = me.filtro3;
      var filtro4 = me.filtro4;

      var url = '/Order/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&column=' + sortedColumn + '&order=' + order + '&filtro1=' + filtro1 + '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4=' + filtro4;
      axios.get(url).then(function(response) {
          var respuesta = response.data;
          me.arrayOrder = respuesta.listado.data;
          me.pagination = respuesta.pagination;
          me.legacySystemHTML = ''
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  },
  mounted() {
    this.listarOrders(1, this.buscar, this.criterio, this.sortedColumn, this.order);
  }
}