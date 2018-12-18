const state = {
  all: []
};
// actions
const actions = {
  getAllProducts({commit}) {
    //commit('setProducts', '');
  }
};

// mutations
const mutations = {
  setProducts(state, products) {
    state.all = products
  },
};

export default {
  state,
  actions,
  mutations
}

