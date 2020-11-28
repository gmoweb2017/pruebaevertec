export default {
    props:['acceso'],
    data(){
      return{
        legacySystemHTML:'',
        formularios:0,
        arrayRoles: [],
        arrayRol: [],
        pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
                },
        offset : 3,
        criterio : 'rol_descripcion',
        sortedColumn: 'rol_descripcion',
        order: 'asc',
        buscar : '',
        tipoAccion : 0,
        tituloModal: '',
        rol_id: 0,
        descripcion: '',
        errorRoles: 0,
        errorMostrarMsjRoles: [],
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
            me.listarRoles(page,buscar,criterio,filtrado);
        },
        orderColumn(sortedColumn,order){            
            if(order=='asc'){
                this.order='desc'      
                order = 'desc'          
            }else{
                this.order='asc'
                order = 'asc'   
            }
            this.listarRoles(1,this.buscar,this.criterio,sortedColumn,order);
        },
        abrirModal(modelo, accion, data = []){
                this.formularios=1;
                switch(modelo){
                    case "Roles":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.formularios = 1;
                                this.tituloModal = 'Registrar ';
                                this.tipoAccion = 1;
                                this.descripcion = '';
                                this.activo = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.formularios=1;
                                this.tipoAccion=2;
                                this.tituloModal='Actualizar ';
                                this.rol_id = data['id'];
                                this.descripcion = data['rol_descripcion'];
                                this.activo = data['rol_activo'];
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
        },
        listarRoles(page,buscar,criterio,sortedColumn,order){
            let me=this;
            me.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
            var url= '/Roles/listado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+'&column='+sortedColumn+'&order='+order;
            axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRoles = respuesta.roles.data;
                    me.pagination= respuesta.pagination;
                    me.legacySystemHTML=''
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        registrar(){
            if (this.validar()){
                return;
            }
            let me = this;
            me.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
            axios.post('/Roles/registrar',{
                    'descripcion': this.descripcion,                    
                    'activo': this.activo
                }).then(function (response) {
                    var placementFrom = "top";
                    var placementAlign = "right";
                    me.legacySystemHTML=''
                    if(response.data.status=="error"){
                            $.notify({
                            icon: response.data.icon,
                            title: response.data.title,
                            message: response.data.message,
                        url:response.data.url,
                        target: '_blank',
                        },{
                                type: response.data.state,
                                placement: {
                                    from: placementFrom,
                                    align: placementAlign
                                },
                                time: 1000,
                            });

                    }else{
                      $.notify({
                            icon: response.data.icon,
                            title: response.data.title,
                            message: response.data.message,
                        url:response.data.url,
                        target: '_blank',
                        },{
                                type: response.data.state,
                                placement: {
                                    from: placementFrom,
                                    align: placementAlign
                                },
                                time: 1000,
                            });
                      me.cerrarFormulario();
                      me.listarRoles(1,'','rol_descripcion',me.sortedColumn,me.order);
                    }

                }).catch(function (error) {
                    console.log(error);
                });
        },
        actualizar(){
            if (this.validar()){
                return;
            }
            let me = this;
            me.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
            axios.put('/Roles/actualizar',{
                    'id': this.rol_id,                    
                    'descripcion': this.descripcion,                    
                    'activo': this.activo
                }).then(function (response) {
                    var placementFrom = "top";
                    var placementAlign = "right";
                    me.legacySystemHTML=''
                    if(response.data.status=="error"){
                            $.notify({
                            icon: response.data.icon,
                            title: response.data.title,
                            message: response.data.message,
                            url:response.data.url,
                            target: '_blank',
                            },{
                                type: response.data.state,
                                placement: {
                                    from: placementFrom,
                                    align: placementAlign
                                },
                                time: 1000,
                            });

                    }else{
                      $.notify({
                            icon: response.data.icon,
                            title: response.data.title,
                            message: response.data.message,
                            url:response.data.url,
                            target: '_blank',
                            },{
                                type: response.data.state,
                                placement: {
                                    from: placementFrom,
                                    align: placementAlign
                                },
                                time: 1000,
                            });
                      me.cerrarFormulario();
                      me.listarRoles(1,'','rol_descripcion',me.sortedColumn,me.order);
                    }

                }).catch(function (error) {
                    console.log(error);
                });
        },
        selectRol(){
            let me=this;
            var url= '/rol/selectRol';
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arrayRol = respuesta.roles;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        desactivar(id){
          swal({
                title: 'Esta seguro de desactivar este registro?',
                text: "Esto hará que no pueda ingresar al sistema!",
                type: 'warning',
                buttons:{
                    confirm: {
                        text : 'Si!',
                        className : 'btn btn-success'
                    },
                    cancel: {
                        text : 'Cancelar',
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                let me = this;
                axios.put('/Roles/desactivar',{
                    'id': id
                }).then(function (response) {
                    me.listarRoles(1,'','rol_descripcion',me.sortedColumn,me.order);
                    swal('Desactivado!','El registro ha sido desactivado con éxito.','success')
                }).catch(function (error) {
                    console.log(error);
                });
                          } else {
                              swal.close();
                          }
                      });

        },
        activar(id){
          swal({
                title: 'Esta seguro de activar este registro?',
                text: "Esto hará que ya pueda ingresar al sistema!",
                type: 'warning',
                buttons:{
                    confirm: {
                        text : 'Si!',
                        className : 'btn btn-success'
                    },
                    cancel: {
                  text : 'Cancelar',
                                  visible: true,
                                  className: 'btn btn-danger'
                              }
                          }
                      }).then((Delete) => {
                          if (Delete) {
                let me = this;
                axios.put('/Roles/activar',{
                    'id': id
                }).then(function (response) {
                    me.listarRoles(1,'','rol_descripcion',me.sortedColumn,me.order);
                    swal('Activado!','El registro ha sido activado con éxito.','success')
                }).catch(function (error) {
                    console.log(error);
                });
                          } else {
                              swal.close();
                          }
                      });

        },
        validar(){
            this.errorRoles=0;
            this.errorMostrarMsjRoles=[];
            var placementFrom = "top";
            var placementAlign = "right";
            if (!this.descripcion) {
                this.errorMostrarMsjRoles.push("El Nombre no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El Nombre no puede estar vacío.",
                    url:'#',
                    target: '_blank',
                    },{
                        type: 'warning',
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 1000,
                    });
            }
            
            if (this.activo==''){
                this.errorMostrarMsjRoles.push("El Estado del Roles no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"Activo no puede estar vacío.",
                    url:'#',
                    target: '_blank',
                    },{
                        type: 'warning',
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 1000,
                    });
            } 

            if (this.errorMostrarMsjRoles.length) this.errorRoles = 1;

            return this.errorRoles;
        },
    },
    mounted() {
        this.listarRoles(1,this.buscar,this.criterio,this.sortedColumn,this.order);
    }
}