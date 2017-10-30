const state = {
  user: JSON.parse(window.localStorage.getItem('authUser')) || null
}

const mutations = {
  SET_AUTH_USER (state, userObj) {
    state.user = userObj
  },
  CLEAR_USER_OBJECT (state) {
    state.user = null
  }
}

const actions = {
  setUserObject: ({commit}, userObject) => {
    commit('SET_AUTH_USER', userObject)
  },
  clearUserObject: ({commit}) => {
    commit('CLEAR_USER_OBJECT')
  }
}

export default { state, mutations, actions }
