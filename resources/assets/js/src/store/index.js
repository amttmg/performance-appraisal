import Vue from 'vue';
import Vuex from 'vuex';
import example from './modules/example';
import user from './modules/user';

Vue.use(Vuex);
export default new Vuex.Store({
  modules: {
    example,
    user
  },
})