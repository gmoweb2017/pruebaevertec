/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
 Vue.filter('capitalize', function(value) {
     if (!value) return ''
     value = value.toString()
     return value.charAt(0).toUpperCase() + value.slice(1)
 })

 Vue.filter('truncate', function(text, length, suffix) {
     return text.substring(0, length) + suffix;
 });

 Vue.filter('redondeo', function(value) {
     if (!value) return ''
     value = value.toFixed(0)
     return value
 })

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)
import lang from 'element-ui/lib/locale/lang/es'
import locale from 'element-ui/lib/locale'

locale.use(lang)

//Modulo de Usuarios
Vue.component('usuarios', require('./components/Usuarios/Usuarios/').default);
Vue.component('roles', require('./components/Usuarios/Roles/').default);

//Modulo de Configuración
Vue.component('configura', require('./components/Configuraciones/ConfiguraApp').default);
Vue.component('modulo', require('./components/Configuraciones/Modulos').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  data: {
      menu: 0
  }
});
