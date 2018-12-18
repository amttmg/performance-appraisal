// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
window._ = require('lodash');
window.qs = require('qs');
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import Toaster from 'v-toaster'

// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'
import VeeValidate from 'vee-validate';
import SweetAlert from './plugins/sweetAlert';
import store from './store/index';
import ValidationErrors from './components/ValidationErrors';

Vue.use(SweetAlert);
Vue.use(VeeValidate, {fieldsBagName: 'formFields'});
Vue.use(BootstrapVue);
Vue.use(Toaster, {timeout: 5000});

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {
    App,
    ValidationErrors
  },
  mounted() {
    this.$store.dispatch('getUser');
  }
});
