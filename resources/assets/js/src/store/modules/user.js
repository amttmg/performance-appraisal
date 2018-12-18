import {getSelf} from "../../actions/UsersActions";
import router from '../../router/index'

const state = {
  user:{
    role:{title:''}
  }
};
const getters = {
  userMenus: state => state.user.menus,
  getRole: state => state.user.role
};
// actions
const actions = {
  getUser({commit}) {
    getSelf().then(res => {
      commit('setUser', res.data.data);
      commit('redirectAccordingToRole', res.data.data);
    }).catch(res => {
      console.log(res);
    })
  }
};

// mutations
const mutations = {
  setUser(state, user) {
    state.user = user
  },
  redirectAccordingToRole(state, user) {
    if (user.role.title !== 'admin') {
      router.push('/performance-evaluation/form');
    }
  },
};

export default {
  state,
  actions,
  mutations,
  getters
}

