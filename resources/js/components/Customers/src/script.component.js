export default {
  props: ['acceso'],
  data() {
    return {
      legacySystemHTML: '',
      formularios: 0,
      arrayCustomer: [],
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
      sortedColumn: 'customer_name',
      order: 'asc',
      criterio: 'customer_name',
      buscar: '',
      tipoAccion: 0,
      tituloModal: '',
      Customer_id: 0,
      customer_name: '',
      customer_email: '',
      customer_address: '',
      customer_mobile: '',
      newOrder: 'asc',
      errorCustomer: 0,
      errorMostrarMsjCustomer: [],
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
      me.listarCustomers(page, buscar, criterio, sortedColumn, order);
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
      this.listarCustomers(1, this.buscar, this.criterio, sortedColumn, order);
    },
    abrirModal(modelo, accion, data = []) { //Controla la apertura de formulario o listado
      this.formularios = 1;
      switch (modelo) {
        case "Customer":
          {
            switch (accion) {
              case 'registrar':
                {
                  this.formularios = 1;
                  this.tituloModal = 'Registrar Customer';
                  this.tipoAccion = 1;
                  this.customer_name = '';
                  this.customer_email = '';
                  this.customer_address = '';
                  this.customer_mobile = '';
                  break;
                }
              case 'actualizar':
                {
                  this.formularios = 1;
                  this.tipoAccion = 2;
                  this.tituloModal = 'Actualizar Customer';
                  this.Customer_id = data['id'];
                  this.customer_name = data['customer_name'];
                  this.customer_email = data['customer_email'];
                  this.customer_address = data['customer_address'];
                  this.customer_mobile = data['customer_mobile'];
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
      this.Customer_id = 0;
      this.customer_name = '';
      this.customer_email = '';
      this.customer_address = '';
      this.customer_mobile = '';
      this.legacySystemHTML = '';
      this.errorCustomer = 0;
    },
    listarCustomers(page, buscar, criterio, sortedColumn, order) {
      let me = this;
      me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';

      var filtro1 = me.filtro1;
      var filtro2 = me.filtro2;
      var filtro3 = me.filtro3;
      var filtro4 = me.filtro4;

      var url = '/Customer/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&column=' + sortedColumn + '&order=' + order + '&filtro1=' + filtro1 + '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4=' + filtro4;
      axios.get(url).then(function(response) {
          var respuesta = response.data;
          me.arrayCustomer = respuesta.listado.data;
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
      axios.post('/Customer/registrar', {
        'customer_name': this.customer_name,
        'customer_email': this.customer_email,
        'customer_address': this.customer_address,
        'customer_mobile': this.customer_mobile
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
          me.listarCustomers(1, '', 'name', me.sortedColumn, me.order);
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
      axios.put('/Customer/actualizar', {
        'id': this.Customer_id,
        'customer_name': this.customer_name,
        'customer_email': this.customer_email,
        'customer_address': this.customer_address,
        'customer_mobile': this.customer_mobile
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
          me.listarCustomers(1, '', 'name', me.sortedColumn, me.order);
        }

      }).catch(function(error) {
        console.log(error);
      });
    },
    validar() {
      this.errorCustomer = 0;
      this.errorMostrarMsjCustomer = [];

      var placementFrom = "bottom";
      var placementAlign = "left";

      if (!this.customer_name) {
        this.errorMostrarMsjCustomer.push("El Customer no puede estar vacío.");
        $.notify({
          icon: 'fa fa-bell',
          title: 'AVISO',
          message: "El Customer no puede estar vacío.",
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
      if (!this.customer_email) {
        this.errorMostrarMsjCustomer.push("El correo electrónico no puede estar vacío.");
        $.notify({
          icon: 'fa fa-bell',
          title: 'AVISO',
          message: "El correo electrónico no puede estar vacío.",
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

      if (!this.customer_address) {
        this.errorMostrarMsjCustomer.push("La dirección no puede estar vacía.");
        $.notify({
          icon: 'fa fa-bell',
          title: 'AVISO',
          message: "La dirección no puede estar vacía.",
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

      if (this.customer_mobile == '') {
        this.errorMostrarMsjCustomer.push("El Estado del Customer no puede estar vacío.");
        $.notify({
          icon: 'fa fa-bell',
          title: 'AVISO',
          message: "El Estado del Customer no puede estar vacío.",
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

      if (this.errorMostrarMsjCustomer.length) this.errorCustomer = 1;

      return this.errorCustomer;
    },
  },
  mounted() {
    this.selectRol();
    this.listarCustomers(1, this.buscar, this.criterio, this.sortedColumn, this.order);
  }
}