// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import VueResource from 'vue-resource'
import VeeValidate from 'vee-validate'
import store from './store'
import { httpRoot } from './../config/env'

Vue.config.productionTip = false

Vue.use(VeeValidate)

Vue.use(VueResource)
Vue.http.options.root = httpRoot

router.beforeEach((to, from, next) => {
  const authUser = JSON.parse(window.localStorage.getItem('authUser')) || ''
  if (to.meta.requiresAuth) {
    if (authUser.access_token) {
      next()
    } else {
      next({ name: 'login' })
    }
  } else if (to.meta.guest) {
    if (authUser.access_token) {
      next({ name: 'dashboard' })
    } else {
      next()
    }
  } else {
    next()
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
