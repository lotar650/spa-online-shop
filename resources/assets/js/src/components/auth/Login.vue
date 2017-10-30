<template>
  <div class="login-form">
    <form v-on:submit.prevent="handleSubmit">
      <div v-if="this.error.length > 0" class="alert alert-danger">{{ error }}</div>
      <div class="form-group">
        <label for="email">Email address:</label>
        <input 
          v-model="auth.email"
          v-validate="'required|email'"
          type="email" 
          class="form-control" 
          name="email"
          id="email"
          autofocus>
        <div v-show="errors.has('email')"
          class="alert alert-danger">
          {{ errors.first('email') }}
        </div>
      </div>

      <div class="form-group">
        <label for="pwd">Password:</label>
        <input 
          v-model="auth.password"
          v-validate="'required|min:6'"
          type="password" 
          class="form-control" 
          id="pwd"
          name="password">
        <div v-show="errors.has('password')"
          class="alert alert-danger">
          {{ errors.first('password') }}
        </div>
      </div>
      <button v-if="this.auth.email.length 
      && this.auth.password.length 
      && !errors.any()" 
      type="submit" 
      class="btn btn-default">
        Login
      </button>
    </form>
  </div>
</template>

<script>
import { clientSecret, getHeaders } from './../../../config/env'

export default {
  name: 'login',
  data () {
    return {
      auth: {
        email: '',
        password: ''
      },
      error: ''
    }
  },
  methods: {
    handleSubmit () {
      const data = {
        grant_type: 'password',
        client_id: 2,
        client_secret: clientSecret,
        username: this.auth.email,
        password: this.auth.password,
        scope: ''
      }
      const authUser = {}
      this.$http.post('oauth/token', data)
      .then(response => {
        if (response.status === 200) {
          authUser.access_token = response.data.access_token
          window.localStorage.setItem('authUser', JSON.stringify(authUser))
          this.$http.get('api/user', { headers: getHeaders() })
            .then(response => {
              authUser.name = response.data.name
              authUser.email = response.data.email
              authUser.user_id = response.data.id
              window.localStorage.setItem('authUser', JSON.stringify(authUser))
              this.$store.dispatch('setUserObject', authUser)
              this.$router.push({ name: 'products' })
            })
        }
      })
      .catch(error => (this.error = error.body.message))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.login-form {
  width: 100%;
  position: fixed;
  top: 30%;
  display: flex;
  align-items: center;
  justify-content: center; 
  overflow: auto; 
  text-align: center; 
}
</style>
