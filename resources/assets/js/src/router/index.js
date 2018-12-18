import Vue from 'vue'
import Router from 'vue-router'
import dashboard from "./dashboard";
import store from '../store/index';

Vue.use(Router);

const router = new Router({
  mode: 'hash', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({y: 0}),
  routes: dashboard
});
router.beforeEach((to, from, next) => {
  let role = store.getters.getRole ? store.getters.getRole.title : '';
  if (to.name === 'Dashboard') {
    if (!(role === 'admin' || role === '' )) {
      return next(false);
    }
  }
  return next();
});
export default router;
