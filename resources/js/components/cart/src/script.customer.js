export default {
  props: ["Producto", "Precio"],
  data() {
    return {
      legacySystemHTML: '',
      formularios: 0,
      customer_name: '',
      customer_address: '',
      customer_mobile: '',
      customer_email: '',
      tipoAccion: 1,

    }
  },

  computed: {

  },
  methods: {
    closeModal() {

    },
  },
  mounted() {
    console.log(this.Producto)
    console.log(this.Precio)
  }
}