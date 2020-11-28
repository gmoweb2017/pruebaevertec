export default {
    props:['acceso'],
    data(){
      return{
        legacySystemHTML:'',
        formularios:0,
        arrayUsuario: [],
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
        sortedColumn: 'username',
        order: 'asc',
        criterio : 'name',
        buscar : '',
        tipoAccion : 0,
        tituloModal: '',
        User_id: 0,
        name: '',
        surname: '',
        username: '',
        email: '',
        password: '',
        rol: '',
        activo: '',
        newOrder :'asc',
        errorUsuario: 0,
        errorMostrarMsjUsuario: [],
        oculta: 0,
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
        },
        
    },
    methods : {
        cambiarPagina(page,buscar,criterio,sortedColumn,order){
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarUsuarios(page,buscar,criterio,sortedColumn,order);
        },
        abreFiltro(){
            console.log(this.oculta);
            if(this.oculta==0){
                this.oculta=1;
            }else{
                this.oculta=0;
            }
        },
        abrirModal(modelo, accion, data = []){
                this.formularios=1;
                
                switch(modelo){
                    case "Usuario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.formularios = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.tipoAccion = 1;
                                this.name='';
                                this.username='';
                                this.surname='';
                                this.email='';
                                this.password='';
                                this.rol='';
                                this.activo='';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.formularios=1;
                                this.tipoAccion=2;
                                this.tituloModal='Actualizar Usuario';
                                this.User_id=data['id'];
                                this.username= data['username'];
                                this.name= data['name'];
                                this.surname = data['surname'];
                                this.email= data['email'];
                                this.rol= data['idrol'];
                                this.activo= data['activo'];
                                break;
                            }
                        }
                    }
                }
        },
        orderColumn(sortedColumn,order){            
            if(order=='asc'){
                this.order='desc'      
                order = 'desc'          
            }else{
                this.order='asc'
                order = 'asc'   
            }
            this.listarUsuarios(1,this.buscar,this.criterio,sortedColumn,order);
        },
        cerrarFormulario(){
            this.formularios=0;
            this.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
            this.tituloModal='';
            this.User_id=0;
            this.name='';
            this.surname='';
            this.username='';
            this.email='';
            this.password='';
            this.rol='';
            this.activo='';
            this.legacySystemHTML='';
            this.errorUsuario=0;
        },
        listarUsuarios(page,buscar,criterio,sortedColumn,order){
            let me=this;
            me.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';

            var filtro1 = me.rol;
            var filtro2 = me.name;
            var filtro3 = me.surname;
            var filtro4 = me.username;

            var url= '/Usuario/listado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+'&column='+sortedColumn+'&order='+order+'&filtro1='+filtro1+'&filtro2='+filtro2+'&filtro3='+filtro3+'&filtro4='+filtro4;
            axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuario = respuesta.Usuarios.data;
                    me.pagination= respuesta.pagination;
                    me.legacySystemHTML=''
                })
                .catch(function (error) {
                    console.log(error);
                });
        },        
        selectRol(){
            let me=this;
            var url= '/Roles/selectRol';
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arrayRol = respuesta.roles;
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
            axios.post('/Usuario/registrar',{
                    'name': this.name,
                    'surname': this.surname,
                    'username': this.username,
                    'email': this.email,
                    'password': this.password,
                    'rol': this.rol,
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
                      me.listarUsuarios(1,'','name',me.sortedColumn,me.order);
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
            axios.put('/Usuario/actualizar',{
                    'id': this.User_id,
                    'name': this.name,
                    'surname': this.surname,
                    'username': this.username,
                    'email': this.email,
                    'password': this.password,
                    'rol': this.rol,
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
                      me.listarUsuarios(1,'','name',me.sortedColumn,me.order);
                    }

                }).catch(function (error) {
                    console.log(error);
                });
        },
        validar(){
            this.errorUsuario=0;
            this.errorMostrarMsjUsuario=[];
            
            var placementFrom = "bottom";
            var placementAlign = "center";

            if (!this.name){
                this.errorMostrarMsjUsuario.push("El Nombre no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El nombre no puede estar vacío.",
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
            if (!this.surname){
                this.errorMostrarMsjUsuario.push("El Apellido no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El Apellido no puede estar vacío.",
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
            if (!this.username){
                this.errorMostrarMsjUsuario.push("El Usuario no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El Usuario no puede estar vacío.",
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
            if (!this.email){
                this.errorMostrarMsjUsuario.push("El correo electrónico no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El correo electrónico no puede estar vacío.",
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
            if(this.tipoAccion==1){
              if (!this.password) this.errorMostrarMsjUsuario.push("La contraseña no puede estar vacía.");
              $.notify({
                icon: 'fa fa-bell',
                title: 'AVISO',
                message:"La contraseña no puede estar vacía.",
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

            if (!this.rol){
                this.errorMostrarMsjUsuario.push("El Rol de usuario no puede ser vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El Rol de usuario no puede ser vacío.",
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
                this.errorMostrarMsjUsuario.push("El Estado del usuario no puede estar vacío.");
                $.notify({
                    icon: 'fa fa-bell',
                    title: 'AVISO',
                    message:"El Estado del usuario no puede estar vacío.",
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

            if (this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;

            return this.errorUsuario;
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
                axios.put('/Usuario/desactivar',{
                    'id': id
                }).then(function (response) {
                    me.listarUsuarios(1,'','name',me.sortedColumn,me.order);
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
                axios.put('/Usuario/activar',{
                    'id': id
                }).then(function (response) {
                    me.listarUsuarios(1,'','name',me.sortedColumn,me.order);
                    swal('Activado!','El registro ha sido activado con éxito.','success')
                }).catch(function (error) {
                    console.log(error);
                });
                } else {
                    swal.close();
                }
            });

        },
    },
    mounted() {
        this.selectRol();
        this.listarUsuarios(1,this.buscar,this.criterio,this.sortedColumn,this.order);
    }
}