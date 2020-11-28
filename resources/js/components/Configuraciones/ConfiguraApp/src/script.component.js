export default {
    props:['acceso','nombre','direccion','telefono','pais','web','webdeveloper','developer','copy','email','logo'],
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
        buscar : '',
        tipoAccion : 1,
        tituloModal: '',       
        valorForm:'',
        imagen: '',       
        nombreApp: '',
        direccionA: '',
        telefonoA: '',
        webA: '',
        paisA: '',
        emailA: '',
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
        subirImagen(e){
            
            let files = e.target.files || e.dataTransfer.files;
            let name = e.target.name
            if (!files.length)
                return;
            this.createImage(files[0],name);
        },
        createImage(file,name) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                console.log(name)
                
                    vm.valorForm = e.target.result;
             
                
            };
            this.subirImagen2(file,name)
            reader.readAsDataURL(file);
        },
        subirImagen2(file,name){
            //Creamos el formData
            var data = new  FormData();
            //Añadimos la imagen seleccionada
            data.append('imagen', file);
            data.append('name', name);
            
            //Añadimos el método PUT dentro del formData
            // Como lo hacíamos desde un formulario simple _(no ajax)_
            data.append('_method', 'PUT');
            //Enviamos la petición
            axios.post('/Configuracion/cargaImagen',data)
            .then(response => {
                console.log(response.data.name)                
                    this.valorForm = response.data.valorForm;
             
            })
        },
        cerrarFormulario(){
            window.location='/';
        },
        registrar() {
            /*if (this.validar()) {
                return;
            }*/
            let me = this;
            me.legacySystemHTML = '<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
            axios.post('/Configuracion/registrar', {
                'imagen': this.valorForm,
                'nombreApp':this.nombreApp,
                'email':this.emailA,
                'direccion': this.direccionA,
                'telefono': this.telefonoA,
                'pais': this.paisA,
                'web': this.webA,
            }).then(function(response) {
                var placementFrom = "top";
                var placementAlign = "right";
                if (response.data.status == "error") {
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
                    me.legacySystemHTML = '';
                } else {
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
                       me.legacySystemHTML = '';
                }

            }).catch(function(error) {
                console.log(error);
            });
        },     

    },
    mounted() {
        this.legacySystemHTML='<center> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>';
        this.nombreApp=this.nombre;
        this.emailA= this.email;
        this.direccionA= this.direccion;
        this.telefonoA= this.telefono;
        this.paisA= this.pais;
        this.webA= this.web;
        this.webdeveloper= this.webdeveloper;
        this.developer= this.developer;
        this.copy= this.copy;
        this.valorForm = this.logo;
        //this.listarConfiguracion(1,this.buscar,this.criterio);
        this.legacySystemHTML=''
    }
}