import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/auth/Login'
import Register from '@/components/auth/Register'
import Basket from '@/components/pages/Basket'
import NotFound from '@/components/404/NotFound'
import Products from '@/components/pages/products/Products'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { guest: true }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { guest: true }
    },
    {
      path: '/basket',
      name: 'basket',
      component: Basket,
      meta: { requiresAuth: true }
    },
    {
      path: '/',
      name: 'products',
      component: Products
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound
    }
  ]
})
