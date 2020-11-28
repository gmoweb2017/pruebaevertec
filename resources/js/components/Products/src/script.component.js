export default {
  props: ['acceso'],
  data() {
    return {
      legacySystemHTML: '',
      formularios: 0,
      arrayProduct: [],
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
      sortedColumn: 'nombreProducto',
      order: 'asc',
      criterio: 'nombreProducto',
      buscar: '',
      tipoAccion: 0,
      tituloModal: '',
      Product_id: 0,
      nombreProducto: '',
      precio: '',
      activo: '',
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
      me.listarProducts(page, buscar, criterio, sortedColumn, order);
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
      this.listarProducts(1, this.buscar, this.criterio, sortedColumn, order);
    },
    abrirModal(modelo, accion, data = []) { //Controla la apertura de formulario o listado
      this.formularios = 1;
      switch (modelo) {
        case "Product":
          {
            switch (accion) {
              case 'registrar':
                {
                  this.formularios = 1;
                  this.tituloModal = 'Registrar Product';
                  this.tipoAccion = 1;
                  this.nombreProducto = '';
                  this.precio = '';
                  this.activo = '';
                  break;
                }
              case 'actualizar':
                {
                  this.formularios = 1;
                  this.tipoAccion = 2;
                  this.tituloModal = 'Actualizar Product';
                  this.Product_id = data['id'];
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
      this.Product_id = 0;
      this.nombreProducto = '';
      this.precio = '';
      this.activo = '';
      this.legacySystemHTML = '';
      this.errorProduct = 0;
    },
    listarProducts(page, buscar, criterio, sortedColumn, order) {
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';

      var filtro1 = me.filtro1;
      var filtro2 = me.filtro2;
      var filtro3 = me.filtro3;
      var filtro4 = me.filtro4;

      var url = '/Product/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&column=' + sortedColumn + '&order=' + order + '&filtro1=' + filtro1 + '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4=' + filtro4;
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
    selectRol() {
      let me = this;
      var url = '/Roles/selectRol';
      axios.get(url).then(function(response) {
          var respuesta = response.data;
          me.arrayRol = respuesta.roles;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registrar() {
      if (this.validar()) {
        return;
      }
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
      axios.post('/Product/registrar', {
        'nombreProducto': this.nombreProducto,
        'precio': this.precio,
        'activo': this.activo,
      }).then(function(response) {
        var placementFrom = "top";
        var placementAlign = "right";
        me.legacySystemHTML = ''
        if (response.data.status == "error") {
          $.notify({
            icon: response.data.icon,
            title: response.data.title,
            message: response.data.message,
            url: response.data.url,
            target: '_blank',
          }, {
            type: response.data.state,
            placement: {
              from: placementFrom,
              align: placementAlign
            },
            time: 1000,
          });

        } else {
          $.notify({
            icon: response.data.icon,
            title: response.data.title,
            message: response.data.message,
            url: response.data.url,
            target: '_blank',
          }, {
            type: response.data.state,
            placement: {
              from: placementFrom,
              align: placementAlign
            },
            time: 1000,
          });
          me.cerrarFormulario();
          me.listarProducts(1, '', 'nombreProducto', me.sortedColumn, me.order);
        }

      }).catch(function(error) {
        console.log(error);
      });
    },
    actualizar() {
      if (this.validar()) {
        return;
      }
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
      axios.put('/Product/actualizar', {
        'id': this.Product_id,
        'nombreProducto': this.nombreProducto,
        'precio': this.precio,
        'activo': this.activo,
      }).then(function(response) {
        var placementFrom = "top";
        var placementAlign = "right";
        me.legacySystemHTML = ''
        if (response.data.status == "error") {
          $.notify({
            icon: response.data.icon,
            title: response.data.title,
            message: response.data.message,
            url: response.data.url,
            target: '_blank',
          }, {
            type: response.data.state,
            placement: {
              from: placementFrom,
              align: placementAlign
            },
            time: 1000,
          });

        } else {
          $.notify({
            icon: response.data.icon,
            title: response.data.title,
            message: response.data.message,
            url: response.data.url,
            target: '_blank',
          }, {
            type: response.data.state,
            placement: {
              from: placementFrom,
              align: placementAlign
            },
            time: 1000,
          });
          me.cerrarFormulario();
          me.listarProducts(1, '', 'nombreProducto', me.sortedColumn, me.order);
        }

      }).catch(function(error) {
        console.log(error);
      });
    },
    validar() {
      this.errorProduct = 0;
      this.errorMostrarMsjProduct = [];

      var placementFrom = "bottom";
      var placementAlign = "left";

      if (!this.nombreProducto) {
        this.errorMostrarMsjProduct.push("El Product no puede estar vacío.");
        $.notify({
          icon: 'fa fa-bell',
          title: 'AVISO',
          message: "El Product no puede estar vacío.",
          url: '#',
          target: '_blank',
        }, {
          type: 'warning',
          placement: {
            from: placementFrom,
            align: placementAlign
          },
          time: 1000,
        });
      }

      if (this.errorMostrarMsjProduct.length) this.errorProduct = 1;

      return this.errorProduct;
    },
  },
  mounted() {
    this.selectRol();
    this.listarProducts(1, this.buscar, this.criterio, this.sortedColumn, this.order);
  }
}