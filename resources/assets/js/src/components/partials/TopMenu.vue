<template>
<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <router-link tag="li" :to="{ name: 'products' }">
          <a>Products</a>
        </router-link>
        <router-link v-if="user.access_token" tag="li" :to="{ name: 'basket' }">
          <a>Basket</a>
        </router-link>
      </ul>
      <ul v-if="user.access_token" class="nav navbar-nav navbar-right">
        <li><a @click.prevent="handleLogout" href="#">Logout</a></li>
      </ul>
      <ul v-else class="nav navbar-nav navbar-right">
        <router-link tag="li" :to="{ name: 'login' }">
          <a>Login</a>
        </router-link>
        <router-link tag="li" :to="{ name: 'register' }">
          <a>Register</a>
        </router-link>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'TopMenu',
  computed: {
    ...mapState({
      user: state => state.userStore.user || ''
    })
  },
  methods: {
    handleLogout () {
      window.localStorage.removeItem('authUser')
      this.$store.dispatch('clearUserObject')
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
</style>